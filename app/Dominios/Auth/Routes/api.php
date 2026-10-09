<?php

use App\Dominios\Auth\Controllers\Api\AuthApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthApiController::class, 'login'])->name('api.auth.login');
    Route::post('/register', [AuthApiController::class, 'register'])->name('api.auth.register');
    Route::get('/me', [AuthApiController::class, 'me'])->name('api.auth.me');
    Route::put('/profile', [AuthApiController::class, 'updateProfile'])->name('api.auth.profile.update');
    Route::post('/logout', [AuthApiController::class, 'logout'])->name('api.auth.logout');
});
