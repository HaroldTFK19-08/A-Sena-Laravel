<?php

use App\Dominios\Fichas\Controllers\CourseGroupController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('fichas', CourseGroupController::class);
});