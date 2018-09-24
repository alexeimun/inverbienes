<?php

namespace Rhemo\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Rhemo\Repositories\Contracts\CriteriaInterface;
use Rhemo\Repositories\Contracts\RepositoryCriteriaInterface;
use Rhemo\Repositories\Contracts\RepositoryInterface;
use Rhemo\Traits\UserProfileTrait;

/**
 * Class Repository
 * @package Rhemo\Repositories\
 */
abstract class Repository implements RepositoryInterface, RepositoryCriteriaInterface {

    use UserProfileTrait;
    /**
     * @var Model
     */
    public $model;

    /**
     * @var mixed
     */
    protected $newModel;

    /**
     * @var Collection
     */
    protected $criteria;

    /**
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * @var $storage \Rhemo\Bridge\B2Storage
     */

    protected $storage = false;

    /**
     * Prevents from overwriting same criteria in chain usage
     * @var bool
     */
    protected $preventCriteriaOverwriting = true;

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*']) {
        $this->applyCriteria();
        return $this->model->get($columns);
    }

    /**
     * @param array $relations
     * @return $this
     */
    public function with(array $relations) {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * @param  string $value
     * @param  string $key
     * @return array
     */
    public function lists($value, $key = null) {
        $this->applyCriteria();
        $lists = $this->model->lists($value, $key);
        if(is_array($lists)) {
            return $lists;
        }
        return $lists->all();
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 25, $columns = ['*']) {
        $this->applyCriteria();
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data) {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data) {
        return $this->model->updateOrCreate(['id' => $data['id'] ?? null], $data);
    }

    /**
     * save a model without massive assignment
     *
     * @param array $data
     * @return bool
     */
    public function saveModel(array $data) {
        foreach ($data as $k => $v) {
            $this->model->$k = $v;
        }
        return $this->model->save();
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update($id, array $data, $attribute = "id") {
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     * @param  array $data
     * @param  $id
     * @return mixed
     */
    public function updateRich(array $data, $id) {
        if(!($model = $this->model->find($id))) {
            return false;
        }
        return $model->fill($data)->save();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*']) {
        $this->applyCriteria();
        return $this->model->find($id, $columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail($id, $columns = ['*']) {
        $this->applyCriteria();
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = ['*']) {
        $this->applyCriteria();
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findAllBy($attribute, $value, $columns = ['*']) {
        $this->applyCriteria();
        return $this->model->where($attribute, '=', $value)->get($columns);
    }

    /**
     * Find a collection of models by the given query conditions.
     *
     * @param array $where
     * @param array $columns
     * @param bool $or
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function findWhere($where, $columns = ['*'], $or = false) {
        $this->applyCriteria();
        $model = $this->model;
        foreach ($where as $field => $value) {
            if($value instanceof \Closure) {
                $model = (!$or) ? $model->where($value) : $model->orWhere($value);
            } else if(is_array($value)) {
                if(count($value) === 3) {
                    list($field, $operator, $search) = $value;
                    $model = (!$or) ? $model->where($field, $operator, $search) : $model->orWhere($field, $operator, $search);
                } else if(count($value) === 2) {
                    list($field, $search) = $value;
                    $model = (!$or) ? $model->where($field, '=', $search) : $model->orWhere($field, '=', $search);
                }
            } else {
                $model = (!$or) ? $model->where($field, '=', $value) : $model->orWhere($field, '=', $value);
            }
        }
        return $model->get($columns);
    }

    /**
     * @return $this
     */
    public function resetScope() {
        $this->skipCriteria(false);
        return $this;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function skipCriteria($status = true) {
        $this->skipCriteria = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCriteria() {

        if(is_null($this->criteria)) {
            $this->criteria = new Collection();
        }

        return $this->criteria;
    }

    /**
     * @param CriteriaInterface $criteria
     * @return $this
     */
    public function getByCriteria(CriteriaInterface $criteria) {
        $this->model = $criteria->apply($this->model, $this);
        return $this;
    }

    /**
     * @param CriteriaInterface $criteria
     * @return $this
     */
    public function pushCriteria(CriteriaInterface $criteria) {

        if(is_null($this->criteria)) {
            $this->criteria = new Collection();
        }

        if($this->preventCriteriaOverwriting) {
            // Find existing criteria
            $key = $this->criteria->search(function ($item) use ($criteria) {
                return (is_object($item) && (get_class($item) == get_class($criteria)));
            });
            // Remove old criteria
            if(is_int($key)) {
                $this->criteria->offsetUnset($key);
            }
        }
        $this->criteria->push($criteria);
        return $this;
    }

    /**
     * @return $this
     */
    public function applyCriteria() {

        if($this->skipCriteria === true) {
            return $this;
        }

        foreach ($this->getCriteria() as $criteria) {

            if($criteria instanceof CriteriaInterface) {
                $this->model = $criteria->apply($this->model, $this);
            }

        }

        return $this;
    }

    /**
     * @param $id
     */
    public function softDelete($id) {
        $this->delete($id);
    }

    /**
     * @return \Rhemo\Bridge\B2Storage
     */
    public function storage() {
        if(!$this->storage)
            $this->storage = app()->make('storage');

        return $this->storage;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function restore($id) {
        return $this->model->withTrashed()->where('id', $id)->restore();
    }

    /**
     * Paginates different models in only one
     *
     * @param $data
     * @param int $amount
     * @return LengthAwarePaginator
     * @throws \Exception
     */
    public function complexPaginate($data, $amount = 15) {
        if(!is_array($data))
            throw new \Exception('Not Array given');

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageSearchResults = array_slice($data, ($currentPage - 1) * $amount, $amount);
        return new LengthAwarePaginator($currentPageSearchResults, count($data), $amount);
    }
}