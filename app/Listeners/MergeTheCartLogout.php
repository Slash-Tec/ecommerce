<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
    }
}
