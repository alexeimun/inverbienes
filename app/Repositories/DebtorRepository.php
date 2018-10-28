<?php

namespace Bienes\Repositories;

use Bienes\Models\Debtor;

class DebtorRepository extends Repository {

    /**
     * Create a new repository instance.
     *
     * @param Debtor $model
     */
    public function __construct(Debtor $model) {
        $this->model = $model;
    }

    public function save(array $data) {
        $debtor = parent::save(array_except($data, ['references']));
        if(count($data['references']) > 0) {
            $r = $this->model->find($debtor->id);
            $r->references()->delete();
            $r->references()->createMany($data['references']);
        }
        return $debtor;
    }
    public function all($columns = ['*']) {
       return $this->model->with('references')->get();
    }

}

