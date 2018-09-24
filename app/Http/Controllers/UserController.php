<?php

namespace Rhemo\Http\Controllers;

use Illuminate\Http\Request;
use Rhemo\Repositories\UserRepository;

class UserController extends Controller {

    public function __construct(UserRepository $repository, Request $request) {
        $this->repository = $repository;
        $this->request = $request;
    }

    public function editCurrentUser() {
        return $this->response($this->repository->editCurrentUser($this->request->all()));
    }

    public function deactivate() {
        return $this->response($this->repository->deactivate());
    }

    public function saveContact() {
        $this->repository->saveContact($this->request->all());
        return $this->response('ok');
    }

}

