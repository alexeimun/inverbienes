<?php

namespace Rhemo\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Rhemo\Models\Notification;

class NotificationRepository extends Repository {

    /**
     * Create a new repository instance.
     *
     * @param Notification $model
     */
    public function __construct(Notification $model) {
        $this->model = $model;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getByCurrentUser() {
        return $this->model->where(function (Builder $q) {
            $q->where('user_id', $this->getUserId())
                ->whereDate('created_at', '>', Carbon::now()->subDays(4));
        })->orWhereIn('event_type', [4, 5])
            ->latest()
            ->get()->toArray();
    }

    private function seeNotifications() {
        $this->model->where('seen', false)->update('seen', true);
    }

}

