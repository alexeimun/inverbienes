<?php

namespace Rhemo\Repositories;

use Rhemo\Models\HorseColor;

class HorseColorRepository extends Repository {

    public function __construct(HorseColor $model) {
        $this->model = $model;
    }
}