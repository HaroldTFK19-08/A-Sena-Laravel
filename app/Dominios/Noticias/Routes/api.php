<?php

use App\Dominios\Noticias\Controllers\Api\NewsApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('noticias', NewsApiController::class)
    ->parameters(['noticias' => 'noticia'])
    ->names('api.noticias');
