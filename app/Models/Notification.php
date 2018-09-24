<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\Notification
 *
 * @property int $id
 * @property int|null $event_type
 * @property int|null $user_id
 * @property string|null $detail_id
 * @property string|null $title
 * @property string|null $body
 * @property string|null $person_name
 * @property int|null $seen
 * @property int|null $person_image_id
 * @property string|null $metadata
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Rhemo\Models\Media|null $person_image
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Notification whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Notification whereDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Notification whereEventType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Notification whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Notification wherePersonImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Notification wherePersonName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Notification whereSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Notification whereUserId($value)
 * @mixin \Eloquent
 */
class Notification extends Model {

    protected $guarded = [];
    protected $with = ['person_image'];
    protected $hidden = ['updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person_image() {
        return $this->belongsTo(Media::class, 'person_image_id');
    }
}