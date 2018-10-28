<?php

namespace Bienes\Repositories\Auth;

use Bienes\Models\User;
use Bienes\Repositories\Repository;

class AuthRepository extends Repository {

    /**
     * Create a new repository instance.
     *
     * @param User $user
     */
    public function __construct(User $user) {
        $this->model = $user;
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model|User
     */
    public function register($data) {
        $user = $this->model->create(array_merge($this->userInput($data), [
            'password' => app('hash')->make($data['password'])
        ]));
        return $user;
    }

    /**
     * @param $data
     * @return array
     */
    private function userInput($data) {
        return array_only($data, ['email', 'password']);
    }
}

