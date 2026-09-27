<?php

use App\Dominios\Programas\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

Route::get('programas/index', [ProgramController::class, 'index'])->name('programas.index');
Route::get('programas/create', [ProgramController::class, 'create'])->name('programas.create');
Route::post('programas/store', [ProgramController::class, 'store'])->name('programas.store');
Route::get('programas/show/{programa}', [ProgramController::class, 'show'])->name('programas.show');
Route::get('programas/edit/{programa}', [ProgramController::class, 'edit'])->name('programas.edit');
Route::put('programas/update/{programa}', [ProgramController::class, 'update'])->name('programas.update');
Route::delete('programas/destroy/{programa}', [ProgramController::class, 'destroy'])->name('programas.destroy');
