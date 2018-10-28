<?php

namespace Bienes\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Bienes\Models\City
 *
 * @property int $id
 * @property string $name
 * @property string $department
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\City whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\City whereName($value)
 * @mixin \Eloquent
 */
class City extends Model {

    protected $guarded = [];
}
