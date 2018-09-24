<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\Premium
 *
 * @property int $id
 * @property string $id_dispositivo
 * @property string $nombre
 * @property string $marca_dispositivo
 * @property int $tipo
 * @property int $distribuidor
 * @property string $token_mqtt
 * @property string|null $fecha_inicio_suscripcion
 * @property int $tipo_suscripcion
 * @property int $estado
 * @property int $suscritos
 * @property int $id_caballo_activo
 * @property int $id_propietario
 * @property int $id_lugar
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Premium whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Premium whereDistribuidor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Premium whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Premium whereFechaInicioSuscripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Premium whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Premium whereIdCaballoActivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Premium whereIdDispositivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Premium whereIdLugar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Premium whereIdPropietario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Premium whereMarcaDispositivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Premium whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Premium whereSuscritos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Premium whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Premium whereTipoSuscripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Premium whereTokenMqtt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Premium whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Premium extends Model {

    protected $table = "premium";

    protected $fillable = ['id_dispositivo', 'id_caballo', 'marca_dispositivo', 'tipo', 'distribuidor', 'tipo_de_conexion', 'fecha_inicio_suscripcion', 'tipo_suscripcion', 'estado', 'id_lugar', 'id_propietario'];
    protected $hidden = ['id_lugar', 'id_caballo'];

}
