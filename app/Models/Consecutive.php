<?php

namespace Bienes\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Bienes\Models\Consecutive
 *
 * @property int $invoice
 * @property int $solicitude
 * @property int $daily_block
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Consecutive whereDailyBlock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Consecutive whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Consecutive whereSolicitude($value)
 * @mixin \Eloquent
 */
class Consecutive extends Model {

    public $timestamps = false;
    protected $guarded = [];
}
