<?php

use App\Dominios\Competencias\Controllers\CompetitionController;
use Illuminate\Support\Facades\Route;

Route::resource('competencias', CompetitionController::class);
