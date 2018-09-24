<?php

namespace Rhemo\Http\Controllers;

use Illuminate\Http\Request;
use Rhemo\Repositories\SocialRepository;

class SocialController extends Controller {

    public function __construct(SocialRepository $repository, Request $request) {
        $this->repository = $repository;
        $this->request = $request;
    }

    public function search($keyword) {
        return $this->response($this->repository->search($keyword));
    }

    public function savePost() {
        return $this->response($this->repository->savePost($this->request->all()));
    }

    public function follow($profile_id) {
        return $this->response($this->repository->follow($profile_id, $this->request->all()));
    }

    public function followers() {
        return $this->response($this->repository->followers());
    }

    public function getPostById($id) {
        return $this->response($this->repository->getPostById($id));
    }

    public function postsFrom($id) {
        return $this->response($this->repository->postsFrom($id, $this->request->exists('page')));
    }

    public function timeline() {
        return $this->response($this->repository->timeline($this->request->exists('page')));
    }

    public function posts() {
        return $this->response($this->repository->posts($this->request->exists('page')));
    }

    public function comment($id) {
        return $this->response($this->repository->comment($id, $this->request->all()));
    }

    public function like($id) {
        return $this->response($this->repository->like($id, $this->request->type));
    }

    public function getPostComments($post_id) {
        return $this->response($this->repository->getPostComments($post_id));
    }

    public function getTaggedHorsePosts($user_id, $horse_id) {
        return $this->response($this->repository->getTaggedHorsePosts($user_id, $horse_id));
    }

    public function following($user_id) {
        return $this->response($this->repository->following($user_id));
    }

    public function followme($user_id) {
        return $this->response($this->repository->followme($user_id));
    }

    public function getHighligths() {
        return $this->response($this->repository->getHighligths());
    }

    public function activeProfiles() {
        return $this->response($this->repository->activeProfiles());
    }

}