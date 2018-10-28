<?php

namespace Bienes\Http\Controllers;

use Bienes\Repositories\InvoiceRepository;
use Illuminate\Http\Request;

class InvoiceController extends Controller {

    public function __construct(InvoiceRepository $repository, Request $request) {
        $this->repository = $repository;
        $this->request = $request;
    }

    public function getConsecutive() {
        return $this->repository->getConsecutive();
    }

    public function cancel($id) {
        return $this->repository->cancelInvoice($id);
    }
}

