<?php

namespace Bienes\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Bienes\Models\PromissoryNote
 *
 * @property int $mortgage_id
 * @property int $value
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\PromissoryNote whereMortgageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\PromissoryNote whereValue($value)
 * @mixin \Eloquent
 */
class PromissoryNote extends Model {

    protected $guarded = [];
    public $timestamps = false;
}
