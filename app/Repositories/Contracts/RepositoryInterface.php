<?php

namespace Rhemo\Repositories\Contracts;

interface RepositoryInterface {
	
	/**
     * Save a new entity in repository
     *
     * @param array $data
     *
     * @return mixed
     */

    public function create(array $data);


	/**
     * Update a entity in repository by id
     *
     * @param array $data
     * @param       $id
     *
     * @return mixed
     */
	public function update($id, array $data);


	/**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return int
     */
	public function delete($id);
	
	/**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
	public function find($id);
}