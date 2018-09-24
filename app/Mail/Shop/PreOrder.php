<?php

namespace Rhemo\Mail\Shop;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PreOrder extends Mailable {

    use Queueable, SerializesModels;

    private $subscription;

    /**
     * Create a new message instance.
     * @param $subscription
     */
    public function __construct($subscription) {
        $this->subscription = $subscription;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build() {
        return $this->view('shop.preorder', ['subscription' => $this->subscription])
            ->subject('Nuevo orden de compra');
    }
}