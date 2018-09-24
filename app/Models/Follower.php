<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\Follower
 *
 * @property int $user_id
 * @property int $profile_id
 * @property string $profile_type
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Follower whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Follower whereProfileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Follower whereUserId($value)
 * @mixin \Eloquent
 */
class Follower extends Model {

    protected $guarded = [];
    protected $visible = ['profile_id', 'profile_type'];

}