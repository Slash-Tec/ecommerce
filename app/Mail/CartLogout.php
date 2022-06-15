<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CartLogout extends Mailable
{
    use Queueable, SerializesModels;

    public $cartlogout;

    public function __construct(CartLogout $cartlogout)
    {
        $this->cartlogout = $cartlogout;
    }

    public function build()
    {
        return $this->view('mails.CartLogout');
    }
}
