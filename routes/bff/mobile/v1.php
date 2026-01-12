<?php

use App\BFF\Mobile\V1\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])
    ->name('auth.login');

Route::middleware(['bff.mobile.v1.auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('auth.logout');

    Route::get('/me', [AuthController::class, 'me'])
        ->name('auth.me');

});
