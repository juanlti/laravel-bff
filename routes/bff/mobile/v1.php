<?php

use App\BFF\Mobile\V1\Controllers\AuthController;
use App\BFF\Mobile\V1\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])
    ->name('auth.login');

Route::middleware(['bff.mobile.v1.auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('auth.logout');

    Route::get('/me', [AuthController::class, 'me'])
        ->name('auth.me');

    //products
    Route::get('products/{id}',[ProductController::class,'show'])->name('product.show');
    Route::get('products',[ProductController::class,'index'])->name('product.name');


});
