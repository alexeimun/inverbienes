<?php

namespace Rhemo\Http\Controllers;

use Illuminate\Http\Request;
use Rhemo\Repositories\RideRepository;

class RideController extends Controller {

    function __construct(Request $request, RideRepository $repository) {
        $this->request = $request;
        $this->repository = $repository;
    }

    public function getMeasurement($id) {
        return $this->response($this->repository->getMeasurement($id));
    }

}