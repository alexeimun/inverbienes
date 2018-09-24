<?php

namespace Rhemo\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Lumen\Auth\Authorizable;
use Rhemo\Traits\ActiveTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Rhemo\Models\User
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string|null $email_token
 * @property int $active
 * @property bool $email_checked
 * @property int $account_type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rhemo\Models\Calendar[] $events
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rhemo\Models\User[] $followable
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rhemo\Models\Follower[] $followers
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rhemo\Models\Horse[] $followingHorses
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rhemo\Models\Profile[] $followingMe
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rhemo\Models\Profile[] $followingUsers
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rhemo\Models\Horse[] $horses
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rhemo\Models\Post[] $posts
 * @property-read \Rhemo\Models\Profile $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rhemo\Models\Calendar[] $schedules
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\User deactivate()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Rhemo\Models\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\User whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\User whereEmailChecked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\User whereEmailToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Rhemo\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Rhemo\Models\User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject {

    use Authenticatable, Authorizable, SoftDeletes, ActiveTrait, Notifiable;

    protected $with = ['profile'];
    protected $guarded = [];
    protected $casts = [
        'email_checked' => 'boolean'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'updated_at',
        'account_type',
        'email_checked',
        'email_token'
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events() {
        return $this->hasMany(Calendar::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts() {
        return $this->hasMany(Post::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function horses() {
        return $this->hasMany(Horse::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile() {
        return $this->hasOne(Profile::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function schedules() {
        return $this->belongsToMany(Calendar::class, 'schedules', 'user_id', 'calendar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followable() {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'profile_id')
            ->withPivot(['profile_type', 'profile_id']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followingMe() {
        return $this->belongsToMany(Profile::class, 'followers', 'profile_id', 'user_id', null, 'user_id')
            ->where('profile_type', 2)
            ->withPivot(['profile_type', 'profile_id']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followingUsers() {
        return $this->belongsToMany(Profile::class, 'followers', 'user_id', 'profile_id', null, 'user_id')
            ->where('profile_type', 2)
            ->withPivot(['profile_type', 'profile_id']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followingHorses() {
        return $this->belongsToMany(Horse::class, 'followers', 'user_id', 'profile_id')
            ->where('profile_type', 1)
            ->withPivot(['profile_type', 'profile_id']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function followers() {
        return $this->hasMany(Follower::class, 'user_id');
    }

    /**
     * @return mixed
     */
    public function likedPosts() {
        return $this->morphedByMany(Post::class, 'likeable');
    }

    /**
     * @return mixed
     */
    public function likedComments() {
        return $this->morphedByMany(Comment::class, 'likeable');
    }

    /**
     * @return array
     */
    public function routeNotificationForOneSignal() {
        return ['tags' => $this->oneSignalTags];
    }
}