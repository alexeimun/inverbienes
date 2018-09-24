<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\Post
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $media_id
 * @property int|null $state
 * @property string|null $body
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $thumbnail_id
 * @property int|null $type
 * @property int|null $action_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rhemo\Models\Comment[] $comments
 * @property-read mixed $comments_count
 * @property-read mixed $is_liked
 * @property-read mixed $is_owner
 * @property-read mixed $likes
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rhemo\Models\Horse[] $horses
 * @property-read \Rhemo\Models\Media|null $media
 * @property-read \Rhemo\Models\Media|null $thumbnail
 * @property-read \Rhemo\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Post whereActionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Post whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Post whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Post whereThumbnailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Post whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Post whereUserId($value)
 * @mixin \Eloquent
 */
class Post extends Model {

    protected $fillable = ['user_id', 'body', 'media_id', 'thumbnail_id', 'action_id', 'type'];
    protected $with = ['user', 'media', 'horses', 'thumbnail'];
    protected $appends = ['is_liked', 'likes', 'is_owner', 'comments_count'];
    protected $hidden = ['updated_at', 'state'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class)->with(['profile' => function ($q) {
            $q->without(['highlight']);
        }]);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
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
        return $this->comments()->count();
    }

    public function getIsOwnerAttribute() {
        return $this->user_id == app('auth')->user()['id'];
    }

    public function media() {
        return $this->belongsTo(Media::class);
    }

    public function thumbnail() {
        return $this->belongsTo(Media::class, 'thumbnail_id');
    }

    public function horses() {
        return $this->belongsToMany(Horse::class, 'post_horse')->withTimestamps()
            ->without(['media', 'prizes', 'genealogy', 'contact', 'highlight', 'certificate']);
    }

}
