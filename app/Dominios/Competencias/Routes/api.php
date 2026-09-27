<?php

use App\Dominios\Competencias\Controllers\Api\CompetitionApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('competencias', CompetitionApiController::class)
    ->parameters(['competencias' => 'competencia'])
    ->names('api.competencias');
