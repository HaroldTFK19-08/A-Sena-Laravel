<?php

use Illuminate\Support\Facades\Route;
use App\Dominios\Ambientes\Controllers\ConsultasController;
Route::get('/consulta1', [ConsultasController::class, 'consulta1']);