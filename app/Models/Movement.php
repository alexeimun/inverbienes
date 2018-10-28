<?php

namespace Bienes\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Bienes\Models\Movement
 *
 * @property int $id
 * @property int|null $invoice_id
 * @property int|null $mortgage_id
 * @property int|null $type
 * @property int|null $value
 * @property int|null $month
 * @property string|null $concept
 * @property string|null $period_extension
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Movement whereConcept($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Movement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Movement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Movement whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Movement whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Movement whereMortgageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Movement wherePeriodExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Movement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Movement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Movement whereValue($value)
 * @mixin \Eloquent
 */
class Movement extends Model {

    protected $guarded = ['period', 'capital_increase'];

    public function mortgage() {
        return $this->belongsTo(Mortgage::class);
    }
}
