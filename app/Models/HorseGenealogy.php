<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\HorseGenealogy
 *
 * @property int $id
 * @property int|null $horse_id
 * @property string|null $father
 * @property string|null $paternal_father
 * @property string|null $paternal_mother
 * @property string|null $mother
 * @property string|null $maternal_father
 * @property string|null $maternal_mother
 * @property string|null $maternal_mother_registry
 * @property string|null $maternal_father_registry
 * @property string|null $mother_registry
 * @property string|null $paternal_mother_registry
 * @property string|null $paternal_father_registry
 * @property string|null $father_registry
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseGenealogy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseGenealogy whereFather($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseGenealogy whereFatherRegistry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseGenealogy whereHorseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseGenealogy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseGenealogy whereMaternalFather($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseGenealogy whereMaternalFatherRegistry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseGenealogy whereMaternalMother($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseGenealogy whereMaternalMotherRegistry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseGenealogy whereMother($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseGenealogy whereMotherRegistry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseGenealogy wherePaternalFather($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseGenealogy wherePaternalFatherRegistry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseGenealogy wherePaternalMother($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseGenealogy wherePaternalMotherRegistry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\HorseGenealogy whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HorseGenealogy extends Model {

    protected $table = "horse_genealogy";
    protected $guarded = [];
    protected $hidden = ['updated_at', 'created_at'];
}


