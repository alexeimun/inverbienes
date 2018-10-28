<?php

namespace Bienes\Http\Controllers;

use Bienes\Repositories\CreditorRepository;
use Illuminate\Http\Request;

class CreditorController extends Controller {

    public function __construct(CreditorRepository $repository, Request $request) {
        $this->repository = $repository;
        $this->request = $request;
    }
}

