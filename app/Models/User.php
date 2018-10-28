<?php

namespace Bienes\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Bienes\Models\User
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property int $active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Bienes\Models\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Bienes\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Bienes\Models\User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject {

    use Authenticatable, Authorizable, SoftDeletes;
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'updated_at'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

}