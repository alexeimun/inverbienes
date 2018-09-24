<?php

namespace Rhemo\Notifications\OneSiginal;

use Illuminate\Notifications\Notification;
use OneSignalNotifier\OneSignal\OneSignalChannel;
use OneSignalNotifier\OneSignal\OneSignalMessage;
use Rhemo\Models\Post;
use Rhemo\Models\User;
use Rhemo\Notifications\OneSignal\Misc\EventType;
use Rhemo\Traits\{
    StoreNotificationTrait, UserProfileTrait
};

class LikePost extends Notification {

    use UserProfileTrait, StoreNotificationTrait;

    private $post;

    /**
     * LikePost constructor.
     * @param Post $post
     */
    public function __construct(Post $post) {
        $this->post = $post;
    }

    /**
     * @param User $notifiable
     * @return array
     */
    public function via(User $notifiable) {
        $this->filterTags($notifiable);
        return $this->getUserId() == $notifiable->id ? [] : [OneSignalChannel::class];
    }

    /**
     * @param User $notifiable
     * @return OneSignalMessage
     */
    public function toOneSignal(User $notifiable) {
        $profile = $this->getCurrentUser()->profile;
        $subject = "A " . $this->getCurrentUser()->profile->name . " le gustó tu publicación.";

        $this->createNotification([
            'user_id' => $notifiable->id,
            'detail_id' => $this->post->id,
            'person_name' => $profile->name,
            'person_image_id' => $profile->media->id,
            'event_type' => EventType::LikePost
        ]);

        return OneSignalMessage::create()
            ->subject($subject)
            ->body('Ver en Rhemo App')
            ->setData('detail_id', $this->post->id)
            ->setData('person_name', $profile->name)
            ->setData('person_image_id', $profile->media->id)
            ->setData('person_image', $profile->media)
            ->setData('event_type', EventType::LikePost);
    }

    public function filterTags($notifiable) {
        $notifiable->oneSignalTags = [
            ['key' => 'userId', 'relation' => '=', 'value' => $notifiable->id],
            ['key' => 'like', 'relation' => '=', 'value' => 'true']
        ];
    }
}