<?php

use App\Dominios\Fichas\Controllers\CourseGroupController;
use Illuminate\Support\Facades\Route;

Route::resource('fichas', CourseGroupController::class);
