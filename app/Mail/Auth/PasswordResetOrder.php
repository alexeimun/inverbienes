<?php

namespace Rhemo\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Rhemo\Models\User;

class PasswordResetOrder extends Mailable {

    use Queueable, SerializesModels;

    /**
     *
     *  the subject the message
     * @var string
     */

    /**
     *
     *  the PasswordReset instance
     * @var PasswordReset
     */
    private $code;
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new message instance.
     * @param User $user
     * @param $code
     */
    public function __construct(User $user, $code) {
        $this->code = $code;
        $this->user = $user;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build() {
        return $this->view('auth.emails.password',
            ['code' => $this->code, 'email' => $this->user->email, 'name' => $this->user->profile->name])
            ->subject('Recupera tu contraseña');
    }
}