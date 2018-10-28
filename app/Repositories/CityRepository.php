<?php

namespace Bienes\Repositories;

use Bienes\Models\City;

class CityRepository extends Repository {

    /**
     * Create a new repository instance.
     *
     * @param City $model
     */
    public function __construct(City $model) {
        $this->model = $model;
    }

}

