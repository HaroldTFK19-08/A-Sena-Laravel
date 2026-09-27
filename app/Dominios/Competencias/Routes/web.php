<?php

use App\Dominios\Competencias\Controllers\CompetitionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('competencias', CompetitionController::class);
});