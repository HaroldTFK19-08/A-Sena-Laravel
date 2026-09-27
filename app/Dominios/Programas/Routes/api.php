<?php

use App\Dominios\Programas\Controllers\Api\ProgramApiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('programas', ProgramApiController::class)
        ->parameters(['programas' => 'programa'])
        ->names('api.programas');
});
