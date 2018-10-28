<?php

namespace Bienes\Http\Controllers;

use Bienes\Repositories\ReportRepository;
use Illuminate\Http\Request;

class ReportController extends Controller {

    public function __construct(ReportRepository $repository, Request $request) {
        $this->repository = $repository;
        $this->request = $request;
    }

    public function debtor($id, $from, $to) {
        return $this->response($this->repository->reportDebtor($id, $from, $to));
    }

    public function dailyIncomes($date) {
        return $this->response($this->repository->dailyIncomes($date));
    }
}

