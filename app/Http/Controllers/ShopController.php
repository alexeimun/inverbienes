<?php

namespace Rhemo\Http\Controllers;

use Illuminate\Http\Request;
use Rhemo\Mail\Mailers;
use Rhemo\Repositories\ShopRepository;

class ShopController extends Controller {

    /**
     *
     * @param Request $request
     * @param ShopRepository $repository
     */

    function __construct(Request $request, ShopRepository $repository) {
        $this->request = $request;
        $this->repository = $repository;
    }

    public function preorder(Mailers $mailers) {
        $mailers->sendEmailPreorder($this->repository->polyfillPreOrder($this->request->all()));
        return $this->response('Mail sended');
    }

    public function show($id) {
        return $this->response($this->repository->getOffer($id));
    }

    public function video() {
        return $this->response($this->repository->getStoreVideo());
    }

    public function getByCategory($category) {
        return $this->response($this->repository->getByCategory($category));
    }

    public function like($id) {
        return $this->response($this->repository->like($id, $this->request->type));
    }

    public function getOfferComments($id) {
        return $this->response($this->repository->getOfferComments($id));
    }

    public function comment($id) {
        return $this->response($this->repository->comment($id, $this->request->all()));
    }

    public function getActiveOffers() {
        return $this->response($this->repository->getActiveOffers());
    }

}

