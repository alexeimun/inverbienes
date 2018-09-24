<?php

namespace Rhemo\Http\Controllers;

use Illuminate\Http\Request;
use Rhemo\Repositories\CertificateRepository;

class CertificateController extends Controller {

    function __construct(Request $request, CertificateRepository $repository) {
        $this->request = $request;
        $this->repository = $repository;
    }

    public function saveCertifcate($id) {
        return $this->repository->saveCertifcate($id, $this->request->all());
    }

    public function getCertificate($id) {
        return $this->repository->getCertificate($id);
    }

    public function getCertificates() {
        return $this->repository->getCertificates();
    }

    public function validateCertificate($id, $value) {
        return $this->repository->validate($id, $value);
    }

}