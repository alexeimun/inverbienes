<?php

namespace Rhemo\Notifications\OneSiginal;

use Illuminate\Notifications\Notification;
use OneSignalNotifier\OneSignal\OneSignalChannel;
use OneSignalNotifier\OneSignal\OneSignalMessage;
use Rhemo\Models\Comment;
use Rhemo\Models\User;
use Rhemo\Notifications\OneSignal\Misc\EventType;
use Rhemo\Traits\{
    StoreNotificationTrait, UserProfileTrait
};

class CommentPost extends Notification {

    use UserProfileTrait, StoreNotificationTrait;

    private $comment;

    /**
     * CommentPost constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment) {
        $this->comment = $comment;
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
        $subject = $profile->name . " comentó tu publicación.";
        $body = $this->comment->body;

        $this->createNotification([
            'user_id' => $notifiable->id,
            'body' => $body,
            'detail_id' => $this->comment->post_id,
            'person_name' => $profile->name,
            'person_image_id' => $profile->media->id,
            'event_type' => EventType::CommentPost
        ]);

        return OneSignalMessage::create()
            ->subject($subject)
            ->body($body)
            ->setData('detail_id', $this->comment->post_id)
            ->setData('person_name', $profile->name)
            ->setData('person_name', $profile->name)
            ->setData('person_image_id', $profile->media->id)
            ->setData('person_image', $profile->media)
            ->setData('event_type', EventType::CommentPost);
    }

    public function filterTags($notifiable) {
        $notifiable->oneSignalTags = [
            ['key' => 'userId', 'relation' => '=', 'value' => $notifiable->id],
            ['key' => 'comment', 'relation' => '=', 'value' => 'true']
        ];
    }
}