<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Rhemo\Models\Like
 *
 * @property int $id
 * @property int $user_id
 * @property int $likeable_id
 * @property string $likeable_type
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Rhemo\Models\Like onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Like whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Like whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Like whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Like whereLikeableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Like whereLikeableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Like whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Like whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Rhemo\Models\Like withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Rhemo\Models\Like withoutTrashed()
 * @mixin \Eloquent
 */
class Like extends Model {

    use SoftDeletes;
    protected $table = 'likeables';
    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',
    ];

    /**
     * Get all of the posts that are assigned this like.
     */
    public function posts() {
        return $this->morphedByMany(Post::class, 'likeable');
    }
}