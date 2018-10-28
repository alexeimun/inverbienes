<?php

namespace Bienes\Traits;

trait UserProfileTrait {

    /**
     * @return int
     */
    public function getUserId() {
        return app('auth')->user()['id'];
    }

    /**
     * @return mixed|\Bienes\Models\User
     */
    public function getCurrentUser() {
        return (object)app('auth')->user();
    }
}