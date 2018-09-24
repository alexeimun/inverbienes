<?php

namespace Rhemo\Notifications\OneSiginal;

use Illuminate\Notifications\Notification;
use OneSignalNotifier\OneSignal\OneSignalChannel;
use OneSignalNotifier\OneSignal\OneSignalMessage;
use Rhemo\Models\User;
use Rhemo\Notifications\OneSignal\Misc\EventType;
use Rhemo\Traits\{
    StoreNotificationTrait, UserProfileTrait
};

class FollowUser extends Notification {

    use UserProfileTrait, StoreNotificationTrait;

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

        $this->createNotification([
            'detail_id' => $this->getUserId(),
            'user_id' => $notifiable->id,
            'person_name' => $profile->name,
            'person_image_id' => $profile->media->id,
            'event_type' => EventType::FollowUser
        ]);

        return OneSignalMessage::create()
            ->subject($profile->name . " te sigue en Rhemo")
            ->body('Ver en Rhemo App')
            ->setData('detail_id', $this->getUserId())
            ->setData('person_name', $profile->name)
            ->setData('person_image', $profile->media)
            ->setData('event_type', EventType::FollowUser);
    }

    public function filterTags($notifiable) {
        $notifiable->oneSignalTags = [
            ['key' => 'userId', 'relation' => '=', 'value' => $notifiable->id],
            ['key' => 'follower', 'relation' => '=', 'value' => 'true']
        ];
    }
}