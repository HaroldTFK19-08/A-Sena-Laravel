<?php

use Illuminate\Support\Facades\Route;
use App\Dominios\Equipos\Controllers\EquipmentController;

Route::get('equipos/index', [EquipmentController::class, 'index'])->name('equipos.index');
Route::get('equipos/create', [EquipmentController::class, 'create'])->name('equipos.create');
Route::post('equipos/store', [EquipmentController::class, 'store'])->name('equipos.store');
Route::get('equipos/show/{equipo}', [EquipmentController::class, 'show'])->name('equipos.show');
Route::get('equipos/edit/{equipo}', [EquipmentController::class, 'edit'])->name('equipos.edit');
Route::put('equipos/update/{equipo}', [EquipmentController::class, 'update'])->name('equipos.update');
Route::delete('equipos/destroy/{equipo}', [EquipmentController::class, 'destroy'])->name('equipos.destroy');