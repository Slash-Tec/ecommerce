<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;
use App\Http\Livewire\Admin\ShowProducts;
use App\Http\Livewire\CreateOrder;
use App\Http\Livewire\PaymentOrder;
use App\Http\Livewire\ShoppingCart;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoryController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', WelcomeController::class);
Route::get('search', SearchController::class)->name('search');
Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('products/{product}', [ProductsController::class, 'show'])->name('products.show');
Route::get('shopping-cart', ShoppingCart::class)->name('shopping-cart');
Route::middleware(['auth'])->group(function (){
Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('orders/create', CreateOrder::class)->name('orders.create');
Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::get('orders/{order}/payment', PaymentOrder::class)->name('orders.payment');
});
Route::get('prueba', function () {
	$orders = \App\Models\Order::where('status', 1)->where('created_at','<',now()->subMinutes(10))->get();
	foreach ($orders as $order) {
		$items = json_decode($order->content);
	foreach ($items as $item) {
		increase($item);
	}
	$order->status = 5;
	$order->save();
}
return "Completado con éxito";
});
Route::get('products/create', CreateProduct::class)->name('admin.products.create');
Route::get('/', ShowProducts::class)->name('admin.index');
Route::get('products/create', function () {})->name('admin.products.create');
Route::get('products/{product}/edit', function () {})->name('admin.products.edit');
