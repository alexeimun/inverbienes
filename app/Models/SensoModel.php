<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\SensoModel
 *
 * @property int $id
 * @property int $id_caballo
 * @property int $id_dispositivo
 * @property string $fecha
 * @property string $hora_inicial
 * @property string $hora_final
 * @property string $intervalos
 * @property string $grafica
 * @property int $estado
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\SensoModel whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\SensoModel whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\SensoModel whereGrafica($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\SensoModel whereHoraFinal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\SensoModel whereHoraInicial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\SensoModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\SensoModel whereIdCaballo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\SensoModel whereIdDispositivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\SensoModel whereIntervalos($value)
 * @mixin \Eloquent
 */
class SensoModel extends Model {

    public $timestamps = false;
    protected $table = "senso";
    protected $guarded = [];
}
