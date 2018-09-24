<?php

namespace Rhemo\Mail\Landing;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LandingOrder extends Mailable {

    use Queueable, SerializesModels;

    private $data;

    /**
     * Create a new message instance.
     * @param $data
     */
    public function __construct($data) {
        $this->data = $data;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build() {
        return $this->view('landing.mailing', ['correo' => $this->data['email'], 'nombre' => $this->data['name']])
            ->subject('Bienvenido a la primera red social en torno al mundo ecuestre');
    }
}