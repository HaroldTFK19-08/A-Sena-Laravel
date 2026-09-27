<?php

use Illuminate\Support\Facades\Route;
use App\Dominios\Centros\Controllers\TrainingCenterController;

Route::get('centros/create', [TrainingCenterController::class, 'create'])
    ->name('centros.create');
Route::get('centros/index', [TrainingCenterController::class, 'index'])
    ->name('centros.index');
Route::post('centros/store', [TrainingCenterController::class, 'store'])
    ->name('centros.store');
Route::get('centros/show/{id}', [TrainingCenterController::class, 'show'])
    ->name('centros.show');
Route::get('centros/edit/{centro}', [TrainingCenterController::class, 'edit'])
    ->name('centros.edit');
Route::put('centros/update/{centro}', [TrainingCenterController::class, 'update'])
    ->name('centros.update');
Route::delete('centros/destroy/{centro}', [TrainingCenterController::class, 'destroy'])
    ->name('centros.destroy');