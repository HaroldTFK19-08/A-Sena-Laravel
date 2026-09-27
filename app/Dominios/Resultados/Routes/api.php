<?php

use App\Dominios\Resultados\Controllers\Api\GradeApiController;
use App\Dominios\Resultados\Controllers\Api\ResultApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('resultados', ResultApiController::class)
    ->parameters(['resultados' => 'resultado'])
    ->names('api.resultados');

Route::apiResource('calificaciones', GradeApiController::class)
    ->parameters(['calificaciones' => 'calificacion'])
    ->names('api.calificaciones');
