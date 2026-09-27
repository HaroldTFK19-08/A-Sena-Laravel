<?php

use App\Dominios\Fichas\Controllers\Api\CourseGroupApiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('fichas', CourseGroupApiController::class)
        ->parameters(['fichas' => 'ficha'])
        ->names('api.fichas');
});
