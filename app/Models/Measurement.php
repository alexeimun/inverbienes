<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\Measurement
 *
 * @property int $id
 * @property int|null $ride_id
 * @property string|null $values
 * @property string|null $average
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Measurement whereAverage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Measurement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Measurement whereRideId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Measurement whereValues($value)
 * @mixin \Eloquent
 */
class Measurement extends Model {

    protected $fillable = ['values'];
    public $timestamps = false;
    protected $casts = [
        'values' => 'array'
    ];

}

 	
