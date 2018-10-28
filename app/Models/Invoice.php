<?php

namespace Bienes\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Bienes\Models\Invoice
 *
 * @property int $id
 * @property int|null $mortgage_id
 * @property int|null $user_id
 * @property int $consecutive
 * @property string|null $bank
 * @property string|null $check
 * @property string|null $cancelled_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $pay_type
 * @property int|null $total
 * @property int|null $capital
 * @property-read \Bienes\Models\Mortgage|null $mortgage
 * @property-read \Illuminate\Database\Eloquent\Collection|\Bienes\Models\Movement[] $movements
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Invoice whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Invoice whereCancelledDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Invoice whereCapital($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Invoice whereCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Invoice whereConsecutive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Invoice whereMortgageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Invoice wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Invoice whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Invoice whereUserId($value)
 * @mixin \Eloquent
 */
class Invoice extends Model {

    protected $guarded = [];
    protected $with = ['movements', 'mortgage'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movements() {
        return $this->hasMany(Movement::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mortgage() {
        return $this->belongsTo(Mortgage::class);
    }
}
