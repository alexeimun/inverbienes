<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\Schedule
 *
 * @property int $user_id
 * @property int $calendar_id
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Schedule whereCalendarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Schedule whereUserId($value)
 * @mixin \Eloquent
 */
class Schedule extends Model {

    protected $guarded = [];

}
