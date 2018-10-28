<?php

namespace Bienes\Repositories;

use Bienes\Models\Company;

class CompanyRepository extends Repository {

    /**
     * Create a new repository instance.
     *
     * @param Company $model
     */
    public function __construct(Company $model) {
        $this->model = $model;
    }

    public function company() {
        return $this->model->first();
    }

}

