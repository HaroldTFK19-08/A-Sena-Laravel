<?php

use App\Dominios\Noticias\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::resource('noticias', NewsController::class);
