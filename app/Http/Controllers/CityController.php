<?php

namespace Bienes\Http\Controllers;

use Bienes\Repositories\CityRepository;
use Illuminate\Http\Request;

class CityController extends Controller {

    public function __construct(CityRepository $repository, Request $request) {
        $this->repository = $repository;
        $this->request = $request;
    }
}

