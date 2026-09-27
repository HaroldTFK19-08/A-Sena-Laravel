<?php

use App\Dominios\Asignaciones\Controllers\Api\AssignmentApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('asignaciones', AssignmentApiController::class)
        ->parameters(['asignaciones' => 'asignacion'])
        ->names('api.asignaciones');
});
