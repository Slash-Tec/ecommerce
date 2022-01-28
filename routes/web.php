<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
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
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('products/{product}', [ProductsController::class, 'show'])->name('products.show');