<?php

use App\Dominios\Inscripciones\Controllers\Api\RegistrationApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('inscripciones', RegistrationApiController::class)
        ->parameters(['inscripciones' => 'inscripcion'])
        ->names('api.inscripciones');
});
