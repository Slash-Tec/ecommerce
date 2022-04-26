<?php

use App\Http\Livewire\Admin\CreateProduct;
use App\Http\Livewire\Admin\ShowProducts;
use Illuminate\Support\Facades\Route;

Route::get('/', ShowProducts::class)->name('admin.index');
Route::get('products/create', CreateProduct::class)->name('admin.products.create');
Route::get('products/{product}/edit', function () {})->name('admin.products.edit');
Route::post('product/{product}/files', [ProductController::class, 'files'])->name('admin.products.files');
Route::get('categories', [CategoryController::class, 'index'])->name('admin.categories.index');
Route::get('categories/{category}', ShowCategory::class)->name('admin.categories.show');