<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\CommentOffer
 *
 * @property int $id
 * @property int $offer_id
 * @property int $user_id
 * @property string|null $body
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $is_liked
 * @property-read mixed $likes
 * @property-read \Rhemo\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\CommentOffer whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\CommentOffer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\CommentOffer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\CommentOffer whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\CommentOffer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\CommentOffer whereUserId($value)
 * @mixin \Eloquent
 */
class CommentOffer extends Model {

    protected $fillable = ['post_id', 'user_id', 'body', 'user'];
    protected $appends = ['is_liked', 'likes'];
    protected $with = ['user'];
    protected $table = 'comment_offers';
    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    private function total_likes() {
        return $this->morphToMany(User::class, 'likeable')->where('likeables.deleted_at', null);
    }

    public function getLikesAttribute() {
        return $this->total_likes()->count();
    }

    public function getIsLikedAttribute() {
        return $this->total_likes()->where('user_id', app('auth')->user()['id'])->exists();
    }
}
