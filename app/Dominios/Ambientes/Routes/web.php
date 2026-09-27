<?php

use Illuminate\Support\Facades\Route;
use App\Dominios\Ambientes\Controllers\EnvironmentController;

Route::get('ambientes/create', [EnvironmentController::class, 'create'])
    ->name('ambientes.create');
Route::post('ambientes/store', [EnvironmentController::class, 'store'])
    ->name('ambientes.store');
Route::get('ambientes/index', [EnvironmentController::class, 'index'])
    ->name('ambientes.index');
Route::get('ambientes/show/{id}', [EnvironmentController::class, 'show'])
    ->name('ambientes.show');
Route::get('ambientes/edit/{ambiente}', [EnvironmentController::class, 'edit'])
    ->name('ambientes.edit');
Route::put('ambientes/update/{ambiente}', [EnvironmentController::class, 'update'])
    ->name('ambientes.update');
Route::delete('ambientes/destroy/{ambiente}', [EnvironmentController::class, 'destroy'])
    ->name('ambientes.destroy');