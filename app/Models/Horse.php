<?php

namespace Rhemo\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rhemo\Traits\ActiveTrait;

/**
 * Rhemo\Models\Horse
 *
 * @property int $id
 * @property string $name
 * @property string $registry
 * @property int $media_id
 * @property string|null $birthdate
 * @property int|null $height
 * @property int|null $body_condition
 * @property int|null $race
 * @property string|null $location
 * @property int|null $pass
 * @property int|null $genre
 * @property int $active
 * @property int|null $country_id
 * @property int|null $state_id
 * @property int|null $city_id
 * @property int $type
 * @property int $user_id
 * @property int|null $colour
 * @property int|null $has_pregnancy
 * @property string|null $pregnancy_date
 * @property string|null $bio
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $highlight_id
 * @property-read \Rhemo\Models\HorseCertificate $certificate
 * @property-read \Rhemo\Models\HorseGenealogy $genealogy
 * @property-read mixed $age
 * @property-read int $profile_type
 * @property-read \Rhemo\Models\Highlighted|null $highlight
 * @property-read \Rhemo\Models\Media $media
 * @property-read \Rhemo\Models\Profile $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rhemo\Models\Post[] $posts
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rhemo\Models\Prize[] $prizes
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse deactivate()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse lightProfile()
 * @method static \Illuminate\Database\Query\Builder|\Rhemo\Models\Horse onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereBodyCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereGenre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereHasPregnancy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereHighlightId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse wherePass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse wherePregnancyDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereRace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereRegistry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Horse whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Rhemo\Models\Horse withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Rhemo\Models\Horse withoutTrashed()
 * @mixin \Eloquent
 */
class Horse extends Model {

    use SoftDeletes, ActiveTrait;

    protected $guarded = [];
    protected $appends = ['age', 'profile_type'];
    protected $with = ['media', 'prizes', 'genealogy', 'certificate'];
    protected $lightProfile = ['name', 'registry', 'media_id', 'id', 'user_id'];
    protected $hidden = ['active', 'pivot', 'created_at', 'updated_at', 'deleted_at', 'bio'];
    protected $casts = [
        'has_pregnancy' => 'boolean'
    ];

    public function getAgeAttribute() {
        return (new Carbon($this->birthdate))->diffInMonths(Carbon::now());
    }

    /**
     * Get profile type
     *
     * @return int
     */
    public function getProfileTypeAttribute() {
        return 1;
    }

    public function media() {
        return $this->belongsTo(Media::class);
    }

    public function prizes() {
        return $this->hasMany(Prize::class);
    }

    public function genealogy() {
        return $this->hasOne(HorseGenealogy::class);
    }

    public function certificate() {
        return $this->hasOne(HorseCertificate::class);
    }

    public function owner() {
        return $this->belongsTo(Profile::class, 'user_id', 'user_id')->without('media');
    }

    public function posts() {
        return $this->belongsToMany(Post::class, 'post_horse')->withTimestamps();
    }

    public function highlight() {
        return $this->belongsTo(Highlighted::class, 'highlight_id');
    }

    /**
     *  Gets a map of data
     * @param Builder $q
     * @return mixed
     */
    public function scopeLightProfile(Builder $q) {
        return $q->without($this->with)->with(['media', 'owner'])->get($this->lightProfile);
    }

}

 	
