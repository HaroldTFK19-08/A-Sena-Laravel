<?php

use Illuminate\Support\Facades\Route;
use App\Dominios\Ofertas\Controllers\OfferController;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('ofertas', OfferController::class);
    Route::patch('/ofertas/{oferta}/publicar', [OfferController::class, 'publicar'])
        ->name('ofertas.publicar');
    Route::patch('/ofertas/{oferta}/despublicar', [OfferController::class, 'despublicar'])
        ->name('ofertas.despublicar');
});