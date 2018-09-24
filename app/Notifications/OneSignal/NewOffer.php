<?php

namespace Rhemo\Notifications\OneSiginal;

use Illuminate\Notifications\Notification;
use OneSignalNotifier\OneSignal\OneSignalChannel;
use OneSignalNotifier\OneSignal\OneSignalMessage;
use Rhemo\Models\Offer;
use Rhemo\Models\User;
use Rhemo\Notifications\OneSignal\Misc\EventType;
use Rhemo\Traits\{
    StoreNotificationTrait, UserProfileTrait
};

class NewOffer extends Notification {

    use UserProfileTrait, StoreNotificationTrait;

    private $offer;

    /**
     * Likeoffer constructor.
     * @param Offer $offer
     */
    public function __construct(Offer $offer) {
        $this->offer = $offer;
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
        $subject = "Hay una nueva oferta en " . $this->offer->category;
        $this->createNotification([
            'title' => $subject,
            'detail_id' => $this->offer->id,
            'person_image_id' => $this->offer->media ? $this->offer->media->id : null,
            'event_type' => EventType::NewOffer
        ]);
        return OneSignalMessage::create()
            ->subject($subject)
            ->body($this->offer->body)
            ->setData('detail_id', $this->offer->id)
            ->setData('person_image', $this->offer->media)
            ->setData('event_type', EventType::NewOffer);
    }

    public function filterTags($notifiable) {
        $notifiable->oneSignalTags = ['key' => 'offer', 'relation' => '=', 'value' => 'true'];
    }
}