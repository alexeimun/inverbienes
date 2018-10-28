<?php

namespace Bienes\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Bienes\Models\Company
 *
 * @property int $id
 * @property string|null $ceo
 * @property string|null $email
 * @property string|null $nit
 * @property string|null $protocolist_name
 * @property string|null $protocolist_phone
 * @property string|null $phone
 * @property string|null $address
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Company whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Company whereCeo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Company whereNit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Company whereProtocolistName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Company whereProtocolistPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bienes\Models\Company whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Company extends Model {

    protected $guarded = [];
    protected $table = 'company';
}
