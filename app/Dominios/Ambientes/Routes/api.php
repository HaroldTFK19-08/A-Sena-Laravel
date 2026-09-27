<?php

use App\Dominios\Ambientes\Controllers\Api\EnvironmentApiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('ambientes', EnvironmentApiController::class)
        ->parameters(['ambientes' => 'ambiente'])
        ->names('api.ambientes');
});
