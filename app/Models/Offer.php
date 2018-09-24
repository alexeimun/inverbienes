<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\Offer
 *
 * @property int $id
 * @property string $start_date
 * @property string $end_date
 * @property int $priority
 * @property int|null $media_id
 * @property string|null $title
 * @property string|null $author
 * @property string|null $body
 * @property string|null $link
 * @property string $category
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rhemo\Models\CommentOffer[] $comments
 * @property-read mixed $comments_count
 * @property-read mixed $is_liked
 * @property-read mixed $likes
 * @property-read \Rhemo\Models\Media|null $media
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Offer whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Offer whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Offer whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Offer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Offer whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Offer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Offer whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Offer whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Offer wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Offer whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Offer whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Offer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Offer extends Model {

    protected $with = ['media'];
    protected $appends = ['is_liked', 'likes', 'comments_count'];
    protected $guarded = [];

    public function media() {
        return $this->belongsTo(Media::class);
    }

    public function comments() {
        return $this->hasMany(CommentOffer::class);
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

    public function getCommentsCountAttribute() {
        return $this->comments->count();
    }

}

 	
