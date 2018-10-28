<?php

namespace Bienes\Http\Controllers;

use Bienes\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller {

    public function __construct(UserRepository $repository, Request $request) {
        $this->repository = $repository;
        $this->request = $request;
    }
}

