<?php

namespace Rhemo\Repositories;

use Rhemo\Models\Measurement;
use Rhemo\Models\Ride;

class RideRepository extends Repository {

    /**
     * @var Measurement
     */
    private $measurement;

    /**
     * Create a new repository instance.
     *
     * @param Ride $model
     * @param Measurement $measurement
     */

    public function __construct(Ride $model, Measurement $measurement) {
        $this->model = $model;
        $this->measurement = $measurement;
    }

    /**
     * Returns measurement data values
     *
     * @param $id
     * @return mixed|Measurement
     */
    public function getMeasurement($id) {
        return $this->model->find($id)->measurement;
    }

    /**
     * @param array $columns
     * @return \Illuminate\Support\Collection|mixed
     */
    public function all($columns = ['*']) {
        return $this->model->where('user_id', $this->getUserId())->latest('id')->paginate();
    }

    public function delete($id) {
        $this->model->find($id)->measurement()->delete();
        return parent::delete($id);
    }

    public function save(array $data) {
        $_ride = array_except($data, 'values');
        /** @var Ride $ride */
        $ride = parent::save(array_merge($_ride, ['user_id' => $this->getUserId()]));
        $measure = $ride->measurement()->create(array_only($data, 'values'))->toArray();
        return array_except($measure, 'values');
    }
}
