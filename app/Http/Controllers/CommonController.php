<?php

namespace Bienes\Http\Controllers;

use Bienes\Repositories\CommonRepository;
use Illuminate\Http\Request;

class CommonController extends Controller {

    public function __construct(CommonRepository $repository, Request $request) {
        $this->repository = $repository;
        $this->request = $request;
    }

    public function dashboard() {
        return $this->response($this->repository->getDashboard());
    }

    public function nextToPay() {
        return $this->response($this->repository->nextToPay());
    }
}

