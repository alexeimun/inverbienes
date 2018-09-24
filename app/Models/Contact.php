<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\Contact
 *
 * @property int $id
 * @property int|null $profile_id
 * @property int|null $contact_type
 * @property int|null $horses
 * @property string|null $contact
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Contact whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Contact whereContactType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Contact whereHorses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\Contact whereProfileId($value)
 * @mixin \Eloquent
 */
class Contact extends Model {

    protected $visible = ['contact','contact_type','horses'];
    protected $fillable = ['contact', 'contact_type', 'horses'];
    public $timestamps = false;
}
