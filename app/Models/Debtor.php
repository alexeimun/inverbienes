<?php

namespace Bienes\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Bienes\Models\Debtor
 *
 * @property int $id
 * @property int|null $city_id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $cell_phone
 * @property string|null $address
 * @property string|null $document
 * @property string|null $email
 * @property string|null $attendant
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Bienes\Models\City|null $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\Bienes\Models\Reference[] $references
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Debtor whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Debtor whereAttendant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Debtor whereCellPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Debtor whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Debtor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Debtor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Debtor whereDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Debtor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Debtor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Debtor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Debtor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Debtor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Debtor extends Model {

    protected $guarded = [];
    protected $with = ['city'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function references() {
        return $this->hasMany(Reference::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city() {
        return $this->belongsTo(City::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mortgages() {
        return $this->hasMany(Mortgage::class);
    }
}
