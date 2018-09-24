<?php

namespace Rhemo\Http\Controllers;

use Illuminate\Http\Request;
use Rhemo\Repositories\CalendarRepository;

class CalendarController extends Controller {

    public function __construct(CalendarRepository $repository, Request $request) {
        $this->repository = $repository;
        $this->request = $request;
    }

    public function schedule($id) {
        $this->repository->schedule($id);
        return $this->response('ok');
    }

    public function scheduled() {
        return $this->response($this->repository->userScheduled());
    }

    public function saveRhemoEvent() {
        return $this->response($this->repository->saveRhemoEvent($this->request->all()));
    }

    public function getRhemoEvents() {
        return $this->response($this->repository->getRhemoEvents());
    }

    public function getRhemoEvent($id) {
        return $this->response($this->repository->getRhemoEvent($id));
    }

    public function removeRhemoEvent($id) {
        return $this->response($this->repository->removeRhemoEvent($id));
    }
}
