<?php

namespace Rhemo\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Rhemo\Http\Controllers\Controller;
use Rhemo\Mail\Mailers;
use Rhemo\Repositories\Auth\PasswordRepository;

class PasswordController extends Controller {

    /**
     * @var PasswordRepository
     */
    protected $repository;

    public function __construct(PasswordRepository $passwordRepository, Request $request) {
        $this->repository = $passwordRepository;
        $this->request = $request;
    }

    public function postEmail(Mailers $mailers) {
        return $this->response($this->repository->postEmail($mailers,$this->request->email));
    }

    public function redeemCode() {
        return $this->response($this->repository->redeemCode($this->request->all()));
    }

    public function changePassword() {
        return $this->response($this->repository->changePassword($this->request->all()));
    }
}
