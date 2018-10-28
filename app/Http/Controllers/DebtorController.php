<?php

namespace Bienes\Http\Controllers;

use Bienes\Repositories\DebtorRepository;
use Illuminate\Http\Request;

class DebtorController extends Controller {

    public function __construct(DebtorRepository $repository, Request $request) {
        $this->repository = $repository;
        $this->request = $request;
    }
}

