<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\Ride
 *
 * @property int $id
 * @property string|null $bpm
 * @property int|null $user_id
 * @property int|null $horse_id
 * @property string|null $average
 * @property string|null $time
 * @property-read \Rhemo\Models\Horse|null $horse
 * @property-read \Rhemo\Models\Measurement $measurement
 * @property-read \Rhemo\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Ride whereAverage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Ride whereBpm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Ride whereHorseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Ride whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Ride whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Ride whereUserId($value)
 * @mixin \Eloquent
 */
class Ride extends Model {

    protected $guarded = [];
    protected $with = ['horse'];
    public $timestamps = false;
    protected $hidden = ['user_id'];
    protected $casts = [
        'time' => 'array'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class)->with(['profile' => function (Builder $q) {
            $q->without(['highlight']);
        }]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horse() {
        return $this->belongsTo(Horse::class)->without(['prizes', 'genealogy', 'certificate']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function measurement() {
        return $this->hasOne(Measurement::class);
    }

}

 	
