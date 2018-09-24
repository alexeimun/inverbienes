<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\MonitorModel
 *
 * @property int $id
 * @property int $tipo
 * @property int $id_caballo
 * @property string $fecha_inicial
 * @property string $fecha_final
 * @property string $dato
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\MonitorModel whereDato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\MonitorModel whereFechaFinal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\MonitorModel whereFechaInicial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\MonitorModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\MonitorModel whereIdCaballo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\MonitorModel whereTipo($value)
 * @mixin \Eloquent
 */
class MonitorModel extends Model {

    public $primaryKey = ['tipo', 'id_caballo', 'fecha_inicial', 'fecha_final'];
    public $incrementing = false;
    public $timestamps = false;
    protected $table = "monitoring";
    protected $fillable = ['tipo', 'id_caballo', 'fecha_inicial', 'fecha_final', 'dato'];

}
