<?php

namespace Bienes\Repositories;

use Bienes\Models\User;

class UserRepository extends Repository {

    /**
     * Create a new repository instance.
     *
     * @param User $model
     */
    public function __construct(User $model) {
        $this->model = $model;
    }

}

