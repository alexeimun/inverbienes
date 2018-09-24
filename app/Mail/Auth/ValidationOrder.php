<?php

namespace Rhemo\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Rhemo\Models\User;

class ValidationOrder extends Mailable {

    use Queueable, SerializesModels;

    /**
     *
     *  the User instance
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     * @param User $user
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build() {
        return $this->view('auth.emails.verify',
            ['name' => $this->user->profile->name, 'email' => $this->user->email, 'token' => $this->user->email_token])
            ->subject('Confirmación RHEMO');
    }
}