<?php

namespace Bienes\Models;

use Bienes\Misc\Enums\PaymentType;
use Illuminate\Database\Eloquent\Model;

/**
 * Bienes\Models\Mortgage
 *
 * @property int $id
 * @property int $debtor_id
 * @property int $creditor_id
 * @property int $immovable_id
 * @property int|null $consecutive
 * @property string|null $start_date
 * @property string|null $final_date
 * @property string|null $type
 * @property string|null $state
 * @property int|null $capital
 * @property int|null $initial_balance
 * @property int|null $adjustment
 * @property int|null $commission
 * @property int|null $interest
 * @property int|null $mortgage_percent
 * @property int|null $fee_admin
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Bienes\Models\Movement[] $allPayments
 * @property-read \Bienes\Models\Creditor $creditor
 * @property-read \Bienes\Models\Debtor $debtor
 * @property-read \Illuminate\Database\Eloquent\Collection|\Bienes\Models\Movement[] $extend_capitals
 * @property-read \Bienes\Models\Immovable $immovable
 * @property-read \Illuminate\Database\Eloquent\Collection|\Bienes\Models\Movement[] $interests
 * @property-read \Illuminate\Database\Eloquent\Collection|\Bienes\Models\Movement[] $movements
 * @property-read \Illuminate\Database\Eloquent\Collection|\Bienes\Models\Movement[] $payments
 * @property-read \Illuminate\Database\Eloquent\Collection|\Bienes\Models\PromissoryNote[] $promissory_notes
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereAdjustment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereCapital($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereConsecutive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereCreditorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereDebtorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereFeeAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereFinalDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereImmovableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereInitialBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereMortgagePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Mortgage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Mortgage extends Model {

    protected $guarded = [];
    protected $with = ['debtor', 'creditor', 'immovable'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function debtor() {
        return $this->belongsTo(Debtor::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creditor() {
        return $this->belongsTo(Creditor::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function immovable() {
        return $this->belongsTo(Immovable::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movements() {
        return $this->hasMany(Movement::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments() {
        return $this->hasMany(Movement::class)->where('type', PaymentType::Payment);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allPayments() {
        return $this->hasMany(Movement::class)->where('type', '<>', PaymentType::Interest)->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function interests() {
        return $this->hasMany(Movement::class)->where('type', PaymentType::Interest);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function extend_capitals() {
        return $this->hasMany(Movement::class)->where('type', PaymentType::IncreaseCapital);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function daily_block() {
        return $this->hasMany(Movement::class)->whereIn('type', [
            PaymentType::Payment, PaymentType::PeriodExtended, PaymentType::Commission
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function promissory_notes() {
        return $this->hasMany(PromissoryNote::class);
    }

}
