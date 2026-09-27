<?php

use Illuminate\Support\Facades\Route;
use App\Dominios\Centros\Controllers\ApiController;

Route::prefix('centros')->group(function () {
    Route::get('/', [ApiController::class, 'index']);
    Route::post('/post', [ApiController::class, 'store']);
    Route::get('/{id}', [ApiController::class, 'show']);
    Route::put('/{centro}', [ApiController::class, 'update']);
    Route::delete('/{centro}', [ApiController::class, 'destroy']);
});