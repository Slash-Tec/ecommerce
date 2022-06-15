<?php

namespace App\Listeners;

use App\Mail\CartLogout;
use Illuminate\Auth\Events\Logout;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class MergeTheCartLogout
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        Cart::erase(auth()->user()->id);
        Cart::store(auth()->user()->id);
        Mail::to(auth()->user()->id)->send(
            new CartLogout
        );
    }
}
