<?php

use App\Dominios\Fichas\Controllers\Api\CourseGroupApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('fichas', CourseGroupApiController::class)
    ->parameters(['fichas' => 'ficha'])
    ->names('api.fichas');
