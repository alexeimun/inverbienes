<?php

namespace Bienes\Repositories;

use Bienes\Models\Creditor;

class CreditorRepository extends Repository {

    /**
     * Create a new repository instance.
     *
     * @param Creditor $model
     */
    public function __construct(Creditor $model) {
        $this->model = $model;
    }

}

