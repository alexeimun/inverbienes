<?php

namespace Rhemo\Traits;

trait UserProfileTrait {

    /**
     * @return int
     */
    public function getUserId() {
        return app('auth')->user()['id'];
    }

    /**
     * @return mixed|\Rhemo\Models\User
     */
    public function getCurrentUser() {
        return (object)app('auth')->user();
    }
}