<?php

namespace Rhemo\Notifications\OneSiginal;

use Illuminate\Notifications\Notification;
use OneSignalNotifier\OneSignal\OneSignalChannel;
use OneSignalNotifier\OneSignal\OneSignalMessage;
use Rhemo\Models\Calendar;
use Rhemo\Models\User;
use Rhemo\Notifications\OneSignal\Misc\EventType;
use Rhemo\Traits\{
    StoreNotificationTrait, UserProfileTrait
};

class NewCalendarEvent extends Notification {

    use UserProfileTrait, StoreNotificationTrait;

    /**
     * @var Calendar
     */
    private $event;

    public function __construct(Calendar $event) {
        $this->event = $event;
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

        $this->createNotification([
            'detail_id' => $this->event->id,
            'event_type' => EventType::NewCalendarEvent
        ]);

        return OneSignalMessage::create()
            ->subject($subject)
            ->body($this->event->title)
            ->setData('detail_id', $this->event->id)
            ->setData('person_image_id', $profile->media->id)
            ->setData('person_image', $profile->media)
            ->setData('event_type', EventType::NewCalendarEvent);
    }

    public function filterTags($notifiable) {
        $notifiable->oneSignalTags = ['key' => 'event', 'relation' => '=', 'value' => 'true'];
    }
}