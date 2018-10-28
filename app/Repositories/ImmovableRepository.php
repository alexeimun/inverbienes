<?php

namespace Bienes\Repositories;

use Bienes\Models\Immovable;
use Bienes\Models\Mortgage;
use Illuminate\Database\Eloquent\Builder;

class ImmovableRepository extends Repository {

    /**
     * @var Mortgage
     */
    private $mortgage;

    /**
     * Create a new repository instance.
     *
     * @param Immovable $model
     * @param Mortgage $mortgage
     */
    public function __construct(Immovable $model, Mortgage $mortgage) {
        $this->model = $model;
        $this->mortgage = $mortgage;
    }

    /**
     * @param $id
     * @param $isRelated
     * @return \Illuminate\Support\Collection
     */
    public function getByDebtor($id, $isRelated) {
        return $this->model->where('debtor_id', $id)
            ->where(function (Builder $q) use ($id, $isRelated) {
                if($isRelated === 'true') {
                    $ids = $this->mortgage->where('debtor_id', $id)->get()->pluck('immovable_id');
                    $q->whereNotIn('id', $ids);
                }
            })->without(['owner', 'city'])->get();
    }

}

