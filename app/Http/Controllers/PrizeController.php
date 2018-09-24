<?php

namespace Rhemo\Http\Controllers;

use Illuminate\Http\Request;
use Rhemo\Repositories\PrizeRepository;

class PrizeController extends Controller {

    /**
     *
     * @param Request $request
     * @param PrizeRepository $repository
     */

    function __construct(Request $request, PrizeRepository $repository) {
        $this->request = $request;
        $this->repository = $repository;
    }
}