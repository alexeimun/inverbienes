<?php

namespace Bienes\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Bienes\Models\Creditor
 *
 * @property int $id
 * @property int|null $city_id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $cell_phone
 * @property string|null $address
 * @property string|null $document
 * @property string|null $email
 * @property string|null $account_name
 * @property string|null $account_number
 * @property string|null $portfolio_management
 * @property string|null $personally_claim
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Bienes\Models\City|null $city
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Creditor whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Creditor whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Creditor whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Creditor whereCellPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Creditor whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Creditor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Creditor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Creditor whereDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Creditor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Creditor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Creditor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Creditor wherePersonallyClaim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Creditor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Creditor wherePortfolioManagement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Creditor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Creditor extends Model {

    protected $guarded = [];
    protected $with = ['city'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city() {
        return $this->belongsTo(City::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mortgages() {
        return $this->hasMany(Mortgage::class);
    }
}
