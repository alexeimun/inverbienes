<?php

namespace Rhemo\Http\Controllers;

use Illuminate\Http\Request;
use Rhemo\Repositories\HorseRaceRepository;

class HorseRaceController extends Controller {

    public function __construct(HorseRaceRepository $repository, Request $request) {
        $this->request = $request;
        $this->repository = $repository;
    }
}