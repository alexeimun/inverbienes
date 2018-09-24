<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\Prize
 *
 * @property int $id
 * @property string $name
 * @property int $position
 * @property int $category
 * @property string|null $date
 * @property string|null $location
 * @property int|null $pass
 * @property int $country_id
 * @property int $city_id
 * @property int $state_id
 * @property int $horse_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Prize whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Prize whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Prize whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Prize whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Prize whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Prize whereHorseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Prize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Prize whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Prize whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Prize wherePass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Prize wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Prize whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Prize whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Prize extends Model {

    protected $guarded = [];
}

 	
