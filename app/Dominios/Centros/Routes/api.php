<?php

use App\Dominios\Centros\Controllers\Api\TrainingCenterApiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('centros', TrainingCenterApiController::class)
        ->parameters(['centros' => 'centro'])
        ->names('api.centros');
});
