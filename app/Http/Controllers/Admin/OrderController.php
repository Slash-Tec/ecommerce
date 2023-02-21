<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::query()->where('status', '!=', 1);
        if (request('status')) {
            $orders->where('status', request('status'));
        }
        $orders = $orders->get();
        for ($i = 2; $i <= 5; $i++) {
            $ordersByStatus[$i] = Order::where('status', $i)->count();
        }
        return view('admin.orders.index', compact('orders', 'ordersByStatus'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }
}
