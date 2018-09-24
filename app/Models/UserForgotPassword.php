<?php

namespace Rhemo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rhemo\Models\UserForgotPassword
 *
 * @property string $email
 * @property string $code
 * @property string $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\UserForgotPassword whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\UserForgotPassword whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rhemo\Models\UserForgotPassword whereEmail($value)
 * @mixin \Eloquent
 */
class UserForgotPassword extends Model {

    public $primaryKey = 'email';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = "password_resets";
    protected $fillable = ['email', 'code'];
}
