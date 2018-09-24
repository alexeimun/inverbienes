<?php

namespace Rhemo\Http\Controllers;

use Illuminate\Http\Request;
use Rhemo\Repositories\HorseRepository;

class HorseController extends Controller {

    function __construct(Request $request, HorseRepository $repository) {
        $this->request = $request;
        $this->repository = $repository;
    }

    public function save() {
        $response = $this->repository->save($this->request->all());
        return $this->response($response, is_array($response) ? 400 : 200);
    }

    public function show($id) {
        return $this->repository->find($id)->load(['owner', 'posts']);
    }

    public function userHorses($user_id) {
        return $this->repository->userHorses($user_id);
    }

    public function saveGenealogy($id) {
        return $this->repository->saveGenealogy($id, $this->request->all());
    }

    public function getGenealogy($id) {
        return $this->repository->getHorseGenealogy($id);
    }

    public function globalHorses() {
        return $this->repository->globalHorses();
    }

    public function colorsAndRaces() {
        return $this->repository->getColorsAndRaces();
    }

    public function searchGenealogyByName($keyword) {
        return $this->repository->searchGenealogyByName($keyword);
    }
    public function searchAncestor() {
        return $this->repository->searchAncestor($this->request->all());
    }
}