<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

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
            }
        }

        $categories = Category::all();
        return view('welcome', compact('categories'));
    }
}
