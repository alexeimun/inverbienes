<?php

namespace Rhemo\Repositories;

use Rhemo\Models\Media;

class MediaRepository extends Repository {

    /**
     * Create a new repository instance.
     *
     * @param Media $model
     */
    public function __construct(Media $model) {
        $this->model = $model;
    }

}

