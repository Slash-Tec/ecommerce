<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Category;

class WelcomeController extends Controller
    {
        public function __invoke()
        {
            if (auth()->user()) {
                $pendientes = Order::where('user_id', auth()->user()->id)->where('status', 1)->count();
                if ($pendientes) {
                    $mensaje = "Tiene $pendientes ordenes pendientes de pago. <a class='font-bold' href='" . route('orders.index') .
                "?status=1'>Pagar</a>";
                    session()->flash('flash.banner', $mensaje);
                    session()->flash('flash.bannerStyle', 'danger');
                }
            }
            $categories = Category::all();

            return view('welcome', compact('categories'));
        }
}
