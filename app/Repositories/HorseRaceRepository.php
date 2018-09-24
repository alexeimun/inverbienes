<?php

namespace Rhemo\Repositories;

use Rhemo\Models\HorseRace;

class HorseRaceRepository extends Repository {

    public function __construct(HorseRace $model) {
        $this->model = $model;
    }
}