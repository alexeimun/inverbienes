<?php

namespace Bienes\Http\Controllers;

use Bienes\Repositories\MortgageRepository;
use Illuminate\Http\Request;

class MortgageController extends Controller {

    public function __construct(MortgageRepository $repository, Request $request) {
        $this->repository = $repository;
        $this->request = $request;
    }

    public function getInterests($id) {
        return $this->response($this->repository->getInterests($id));
    }

    public function getPayments($id) {
        return $this->response($this->repository->getPayments($id));
    }

    public function transferMortgageCreditor() {
        return $this->response($this->repository->transferMortgageCreditor($this->request->all()));
    }

    public function transferMortgageDebtor() {
        return $this->response($this->repository->transferMortgageDebtor($this->request->all()));
    }
}

