<?php

namespace Rhemo\Http\Controllers;

use Illuminate\Http\Request;
use Rhemo\Repositories\HorseColorRepository;

class HorseColorController extends Controller {

    public function __construct(HorseColorRepository $repository, Request $request) {
        $this->repository = $repository;
        $this->request = $request;
    }
}