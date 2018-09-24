<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\Highlighted
 *
 * @property int $id
 * @property int $profile_id
 * @property int $priority
 * @property string $start_date
 * @property string $end_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Highlighted whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Highlighted whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Highlighted whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Highlighted wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Highlighted whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Highlighted whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Highlighted whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Highlighted extends Model {

    protected $table = 'highlights';
    protected $fillable = ['end_date', 'start_date', 'priority', 'profile_id'];
    protected $hidden = ['updated_at', 'created_at'];
}
