<?php

use App\Dominios\Usuarios\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('usuarios', UserApiController::class)
        ->parameters(['usuarios' => 'usuario'])
        ->names('api.usuarios');
});
