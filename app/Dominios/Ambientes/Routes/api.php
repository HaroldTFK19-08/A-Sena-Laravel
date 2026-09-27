<?php

use App\Dominios\Ambientes\Controllers\Api\EnvironmentApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('ambientes', EnvironmentApiController::class)
    ->parameters(['ambientes' => 'ambiente'])
    ->names('api.ambientes');
