<?php

namespace Rhemo\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Rhemo\Repositories\Repository;

class Controller extends BaseController {

    /** @var  Repository $repository */
    protected $repository;
    /** @var  \Illuminate\Http\Request $request */
    protected $request;

    /**
     * Resturns a generic response
     *
     * @param $data
     * @param int $status_code
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function response($data, $status_code = 200, $headers = []) {
        return response()->json($data, $status_code, $headers);
    }

    /**
     * Creates a new record
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store() {
        return $this->response($this->repository->create($this->request->all()));
    }

    /**
     * Updates Or creates a record
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function save() {
        return $this->response($this->repository->save($this->request->all()));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        return $this->response($this->repository->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id) {
        $data = $this->repository->update($id, $this->request->all());
        return $this->response($data);
    }

    /**
     * Fetch all records
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all() {
        return $this->response($this->repository->all());
    }

    /**
     * Mark as removed the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function softDestroy($id) {
        return $this->response($this->repository->softDelete($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        $objModel = $this->repository->find($id);
        $this->repository->delete($id);
        return $this->response($objModel);
    }

    /**
     * Gets the user profile
     *
     * @return mixed|\Rhemo\Models\User
     */
    public function user() {
        return $this->request->user();
    }

    /**
     * Restore a soft deleted record
     * @param $id
     * @return mixed
     */
    public function restore($id) {
        return $this->response($this->repository->restore($id));
    }
}
