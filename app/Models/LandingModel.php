<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\LandingModel
 *
 * @property int $id
 * @property string $nombre
 * @property string $rol
 * @property string $correo
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\LandingModel whereCorreo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\LandingModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\LandingModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\LandingModel whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\LandingModel whereRol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\LandingModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LandingModel extends Model {

    protected $table = "landing";
    protected $fillable = ['nombre', 'rol', 'correo'];

}
