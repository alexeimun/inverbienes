<?php

namespace Bienes\Http\Controllers;

use Bienes\Repositories\CompanyRepository;
use Illuminate\Http\Request;

class CompanyController extends Controller {

    public function __construct(CompanyRepository $repository, Request $request) {
        $this->repository = $repository;
        $this->request = $request;
    }
    public function one() {
        return $this->repository->company();
    }
}

