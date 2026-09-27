<?php

use App\Dominios\Inscripciones\Controllers\Api\RegistrationApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('inscripciones', RegistrationApiController::class)
    ->parameters(['inscripciones' => 'inscripcion'])
    ->names('api.inscripciones');
