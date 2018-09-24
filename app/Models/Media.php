<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\Media
 *
 * @property int $id
 * @property string $url
 * @property int|null $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Media whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Media whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Media whereUrl($value)
 * @mixin \Eloquent
 */
class Media extends Model {

    protected $table = "media";
    protected $visible = ['url', 'type', 'id'];
    protected $guarded = [];

}
