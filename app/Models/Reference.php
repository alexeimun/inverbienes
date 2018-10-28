<?php

namespace Bienes\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Bienes\Models\Reference
 *
 * @property int|null $debtor_id
 * @property string|null $name
 * @property string|null $type
 * @property string|null $phone
 * @property string|null $address
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Reference whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Reference whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Reference whereDebtorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Reference whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Reference wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Reference whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Reference whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Reference extends Model {

    protected $guarded = [];
}
