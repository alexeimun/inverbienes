<?php

namespace Rhemo\Repositories;

use Rhemo\Models\Prize;

class PrizeRepository extends Repository {

    /**
     * Create a new repository instance.
     *
     * @param Prize $model
     */

    public function __construct(Prize $model) {
        $this->model = $model;
    }

    public function save(array $data) {
        $prize = parent::save($data);
        return $this->find($prize->id);
    }

}

