<?php

use App\Dominios\Ofertas\Controllers\Api\OfferApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('ofertas', OfferApiController::class)
        ->parameters(['ofertas' => 'oferta'])
        ->names('api.ofertas');
});
