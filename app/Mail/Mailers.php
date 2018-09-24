<?php

namespace Rhemo\Mail;

use Illuminate\Mail\Mailer;
use Rhemo\Mail\Auth\PasswordResetOrder;
use Rhemo\Mail\Auth\ValidationOrder;
use Rhemo\Mail\Landing\LandingOrder;
use Rhemo\Mail\Shop\PreOrder;
use Rhemo\Models\User;

class Mailers {

    const RHEMO_EMAIL = 'info@rhemo.co';
    /**
     *
     * The Mailer instance
     *
     * @var \Illuminate\Mail\Mailer
     */
    protected $mail;

    /**
     * Create a new Mailers instance.
     *
     * @param Mailer $mailer
     * @return void
     */
    public function __construct(Mailer $mailer) {
        $this->mailer = $mailer;
    }

    /**
     * send email verification
     *
     * @param User $user
     * @return void
     */
    public function sendEmailVerification(User $user) {
        $this->mailer->to($user->email)->queue(new ValidationOrder($user));
    }

    /**
     * send email preorder
     *
     * @param $subscription
     * @return void
     */
    public function sendEmailPreorder($subscription) {
        $this->mailer->to(self::RHEMO_EMAIL)->queue(new PreOrder($subscription));
    }

    /**
     * send email password reset
     *
     * @param User $user
     * @param $code
     * @return void
     */
    public function sendEmailPasswordReset(User $user, $code) {
        $this->mailer->to($user->email)->queue(new PasswordResetOrder($user, $code));
    }

    /**
     * Send landig email
     *
     * @param $data
     */
    public function sendEmailLanding($data) {
        $this->mailer->to($data['email'])->queue(new LandingOrder($data));
    }

}