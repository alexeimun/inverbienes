<?php

namespace Rhemo\Repositories;

use Rhemo\Models\Calendar;
use Rhemo\Models\User;
use Rhemo\Notifications\OneSiginal\NewCalendarEvent;

class CalendarRepository extends Repository {

    protected $user;
    const RHEMO_ACCOUNT = 1;

    /**
     * Create a new repository instance.
     *
     * @param Calendar $model
     * @param User $user
     */

    public function __construct(Calendar $model, User $user) {
        $this->model = $model;
        $this->user = $user;
    }

    public function schedule($id) {
        $this->model->find($id)->schedules()->toggle($this->getUserId());
    }

    public function save(array $data) {
        return parent::save(array_merge($data, ['user_id' => $this->getUserId()]));
    }

    public function notifyNewEvent($event) {
        $this->user->find(self::RHEMO_ACCOUNT)->notify(new NewCalendarEvent($event));
    }

    public function all($columns = ['*']) {
        $schedules = $this->user->find($this->getUserId())
            ->schedules()->get(['schedules.calendar_id', 'schedules.user_id']);
        return ['all' => $this->getRhemoAndUserEvents(), 'schedules' => $schedules];
    }

    public function getRhemoAndUserEvents() {
        return $this->model->whereIn('user_id', [self::RHEMO_ACCOUNT, $this->getUserId()])->get();
    }

    public function userScheduled() {
        $schedules = $this->user->find($this->getUserId())->schedules->toArray();
        $events = $this->user->find($this->getUserId())->events->toArray();
        return array_merge($schedules, $events);
    }

    public function saveRhemoEvent($data) {
        $event = $this->model->updateOrCreate(['id' => $data['id'] ?? null],
            array_merge($data, ['user_id' => self::RHEMO_ACCOUNT]));

        $this->notifyNewEvent($event);
        return $event;
    }

    public function getRhemoEvents() {
        return $this->model->where('user_id', self::RHEMO_ACCOUNT)->get();
    }

    public function getRhemoEvent($id) {
        return $this->model->whereId($id)->first();
    }

    public function removeRhemoEvent($id) {
        return $this->model->whereId($id)->delete();
    }

    public function delete($id) {
        $schedule = app()->make('Rhemo\Models\Schedule');
        $schedule->where('calendar_id', $id)->delete();
        return parent::delete($id);
    }

}

