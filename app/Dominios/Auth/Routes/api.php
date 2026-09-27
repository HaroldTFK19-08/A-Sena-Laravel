<?php

use App\Dominios\Auth\Controllers\Api\AuthApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthApiController::class, 'login'])->name('api.auth.login');
    Route::post('/register', [AuthApiController::class, 'register'])->name('api.auth.register');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthApiController::class, 'me'])->name('api.auth.me');
        Route::post('/logout', [AuthApiController::class, 'logout'])->name('api.auth.logout');
    });
});
