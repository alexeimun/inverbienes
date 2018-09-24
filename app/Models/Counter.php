<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\Counter
 *
 * @property int $id_contenido
 * @property int $id_usuario
 * @property int $tipo
 * @property int $estado
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Counter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Counter whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Counter whereIdContenido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Counter whereIdUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Counter whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Counter whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Counter extends Model {

    public $incrementing = false;
    protected $table = 'counter';
    protected $fillable = ['id_contenido', 'id_usuario', 'tipo', 'estado'];

}



    