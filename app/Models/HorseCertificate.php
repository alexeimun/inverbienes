<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\HorseCertificate
 *
 * @property int $id
 * @property int|null $horse_id
 * @property int|null $certificate_front_id
 * @property int|null $certificate_back_id
 * @property string|null $expedition
 * @property bool $is_validated
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Rhemo\Models\Horse|null $horse
 * @property-read \Rhemo\Models\Media|null $registry_back_media
 * @property-read \Rhemo\Models\Media|null $registry_front_media
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseCertificate whereCertificateBackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseCertificate whereCertificateFrontId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseCertificate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseCertificate whereExpedition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseCertificate whereHorseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseCertificate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseCertificate whereIsValidated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseCertificate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HorseCertificate extends Model {

    protected $guarded = [];
    protected $casts = [
        'is_validated' => 'boolean',
    ];

    public function registry_front_media() {
        return $this->belongsTo(Media::class, 'certificate_front_id');
    }

    public function registry_back_media() {
        return $this->belongsTo(Media::class, 'certificate_back_id');
    }

    public function horse() {
        return $this->belongsTo(Horse::class);
    }

}


