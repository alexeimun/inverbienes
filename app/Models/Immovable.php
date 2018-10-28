<?php

namespace Bienes\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Bienes\Models\Immovable
 *
 * @property int $id
 * @property int|null $debtor_id
 * @property int|null $city_id
 * @property string|null $registration
 * @property string|null $notary
 * @property string|null $nearto
 * @property string|null $writting_number
 * @property string|null $constitution
 * @property string|null $writting_delivery
 * @property string|null $type
 * @property string|null $phone
 * @property string|null $address
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Bienes\Models\City|null $city
 * @property-read \Bienes\Models\Debtor|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Immovable whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Immovable whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Immovable whereConstitution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Immovable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Immovable whereDebtorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Immovable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Immovable whereNearto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Immovable whereNotary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Immovable wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Immovable whereRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Immovable whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Immovable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Immovable whereWrittingDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Immovable whereWrittingNumber($value)
 * @mixin \Eloquent
 */
class Immovable extends Model {

    protected $guarded = [];
    protected $with = ['owner', 'city'];

    public function owner() {
        return $this->belongsTo(Debtor::class, 'debtor_id');
    }

    public function city() {
        return $this->belongsTo(City::class);
    }
}
