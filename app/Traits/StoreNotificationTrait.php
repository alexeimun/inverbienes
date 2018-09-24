<?php

namespace Rhemo\Traits;

use Rhemo\Models\Notification;

trait StoreNotificationTrait {

    public function createNotification($notification) {
        Notification::create($notification);
    }
}