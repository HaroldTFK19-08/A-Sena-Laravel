<?php

use App\Dominios\Asignaciones\Controllers\AssignmentController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('asignaciones', [AssignmentController::class, 'index'])->name('asignaciones.index');
    Route::get('asignaciones/{assignment}', [AssignmentController::class, 'show'])->name('asignaciones.show');
});

Route::prefix('instructor')->name('instructor.')->group(function () {
    Route::get('asignaciones', [AssignmentController::class, 'index'])->name('asignaciones.index');
    Route::get('asignaciones/create', [AssignmentController::class, 'create'])->name('asignaciones.create');
    Route::post('asignaciones', [AssignmentController::class, 'store'])->name('asignaciones.store');
    Route::get('asignaciones/{assignment}', [AssignmentController::class, 'show'])->name('asignaciones.show');
    Route::get('asignaciones/{assignment}/edit', [AssignmentController::class, 'edit'])->name('asignaciones.edit');
    Route::put('asignaciones/{assignment}', [AssignmentController::class, 'update'])->name('asignaciones.update');
    Route::delete('asignaciones/{assignment}', [AssignmentController::class, 'destroy'])->name('asignaciones.destroy');
});
