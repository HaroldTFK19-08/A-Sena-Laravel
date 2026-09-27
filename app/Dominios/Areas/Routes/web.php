<?php

use Illuminate\Support\Facades\Route;
use App\Dominios\Areas\Controllers\AreaController;

Route::get('areas/index', [AreaController::class, 'index'])->name('areas.index');
Route::get('areas/create', [AreaController::class, 'create'])->name('areas.create');
Route::post('areas/store', [AreaController::class, 'store'])->name('areas.store');
Route::get('areas/show/{area}', [AreaController::class, 'show'])->name('areas.show');
Route::get('areas/edit/{area}', [AreaController::class, 'edit'])->name('areas.edit');
Route::put('areas/update/{area}', [AreaController::class, 'update'])->name('areas.update');
Route::delete('areas/destroy/{area}', [AreaController::class, 'destroy'])->name('areas.destroy');
