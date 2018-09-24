<?php

namespace Rhemo\Http\Controllers;

use Illuminate\Http\Request;
use Rhemo\Repositories\HighlightedRepository;

class HighlightedController extends Controller {

    public function __construct(HighlightedRepository $repository, Request $request) {
        $this->repository = $repository;
        $this->request = $request;
    }
}
