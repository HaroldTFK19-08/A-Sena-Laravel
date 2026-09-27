<?php

use App\Dominios\Competencias\Controllers\Api\CompetitionApiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('competencias', CompetitionApiController::class)
        ->parameters(['competencias' => 'competencia'])
        ->names('api.competencias');
});
