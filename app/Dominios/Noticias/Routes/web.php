<?php

use Illuminate\Support\Facades\Route;
use App\Dominios\Noticias\Controllers\NewsController;

Route::middleware(['auth', 'admin'])->group(function () {
	Route::resource('noticias', NewsController::class);
});
