<?php

namespace Bienes\Http\Controllers;

use Bienes\Repositories\ImmovableRepository;
use Illuminate\Http\Request;

class ImmovableController extends Controller {

    public function __construct(ImmovableRepository $repository, Request $request) {
        $this->repository = $repository;
        $this->request = $request;
    }

    public function getByDebtor($id, $related) {
        return $this->response($this->repository->getByDebtor($id, $related));
    }
}

