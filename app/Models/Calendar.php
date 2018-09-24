<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\Calendar
 *
 * @property int $id
 * @property string $title
 * @property string $date
 * @property string|null $start_hour
 * @property string|null $final_hour
 * @property string|null $location
 * @property int $type
 * @property int $user_id
 * @property int $state
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $country_id
 * @property int|null $state_id
 * @property int|null $city_id
 * @property string|null $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rhemo\Models\User[] $schedules
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Calendar whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Calendar whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Calendar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Calendar whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Calendar whereFinalHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Calendar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Calendar whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Calendar whereRoles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Calendar whereStartHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Calendar whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Calendar whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Calendar whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Calendar whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Calendar whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Calendar whereUserId($value)
 * @mixin \Eloquent
 */
class Calendar extends Model {

    protected $table = 'calendar';
    protected $guarded = [];
    protected $hidden = ['updated_at', 'created_at'];

    public function schedules() {
        return $this->belongsToMany(User::class, 'schedules', 'calendar_id', 'user_id');
    }

}
