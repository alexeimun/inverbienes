<?php

namespace Rhemo\Repositories\Contracts;

/**
 * Interface CriteriaInterface
 * @package Rhemo\Repositories\Contracts
 */
interface CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository);
}