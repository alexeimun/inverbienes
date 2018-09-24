<?php

namespace Rhemo\Http\Controllers;

use Illuminate\Http\Request;
use Rhemo\Repositories\NotificationRepository;

class NotificationController extends Controller {

    public function __construct(NotificationRepository $repository, Request $request) {
        $this->repository = $repository;
        $this->request = $request;
    }

    public function getByUser() {
        return $this->repository->getByCurrentUser();
    }
}
