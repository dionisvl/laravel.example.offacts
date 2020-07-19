<?php

use AppSmart\Products\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products', ProductController::class . '@index')->name('productIndex');
Route::post('/products', ProductController::class . '@store')->name('productStore');

Route::get('/products/search', ProductController::class . '@productSearch')->name('productSearch');
