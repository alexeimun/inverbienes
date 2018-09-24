<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rhemo\Traits\ActiveTrait;

/**
 * Rhemo\Models\Profile
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int|null $country_id
 * @property int|null $state_id
 * @property int|null $city_id
 * @property int|null $media_id
 * @property int $active
 * @property int|null $genre
 * @property string|null $phone
 * @property string|null $birthdate
 * @property string|null $interests
 * @property string|null $location
 * @property string|null $bio
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $role
 * @property int|null $highlight_id
 * @property-read \Rhemo\Models\Contact $contact
 * @property-read int $profile_type
 * @property-read \Rhemo\Models\Highlighted|null $highlight
 * @property-read \Rhemo\Models\Media|null $media
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile deactivate()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile lightProfile()
 * @method static \Illuminate\Database\Query\Builder|\Rhemo\Models\Profile onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereGenre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereHighlightId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereInterests($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Profile whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Rhemo\Models\Profile withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Rhemo\Models\Profile withoutTrashed()
 * @mixin \Eloquent
 */
class Profile extends Model {

    use SoftDeletes, ActiveTrait;

    protected $lightProfile = ['name', 'bio', 'media_id', 'user_id', 'role', 'id'];
    protected $with = ['media', 'highlight', 'contact'];
    protected $guarded = [];
    protected $table = 'profile';
    protected $appends = ['profile_type'];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     *  Gets a map of data
     * @param Builder $q
     * @return \Illuminate\Support\Collection
     */
    public function scopeLightProfile(Builder $q) {
        return $q->without($this->with)->with(['media', 'contact', 'highlight'])->get($this->lightProfile);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function media() {
        return $this->belongsTo(Media::class, 'media_id');
    }

    /**
     * Get profile type
     *
     * @return int
     */
    public function getProfileTypeAttribute() {
        return 2;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function highlight() {
        return $this->belongsTo(Highlighted::class, 'highlight_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contact() {
        return $this->hasOne(Contact::class, 'profile_id');
    }

    public function posts() {
        return $this->hasMany(Post::class, 'user_id', 'user_id');
    }

}