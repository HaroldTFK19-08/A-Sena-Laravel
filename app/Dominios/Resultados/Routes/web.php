<?php

use App\Dominios\Resultados\Controllers\ApprenticeResultController;
use App\Dominios\Resultados\Controllers\InstructorResultController;
use App\Dominios\Resultados\Controllers\ResultController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('resultados', ResultController::class);
});

Route::middleware(['auth', 'instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('resultados', [InstructorResultController::class, 'index'])->name('resultados.index');
    Route::get('resultados/fichas/{ficha}', [InstructorResultController::class, 'ficha'])->name('resultados.ficha');
    Route::get('resultados/fichas/{ficha}/competencias/{competencia}/calificar', [InstructorResultController::class, 'calificar'])->name('resultados.calificar');
    Route::put('resultados/fichas/{ficha}/competencias/{competencia}/calificar', [InstructorResultController::class, 'guardar'])->name('resultados.guardar');
});

Route::middleware(['auth', 'aprendiz'])->prefix('aprendiz')->name('aprendiz.')->group(function () {
    Route::get('resultados', [ApprenticeResultController::class, 'index'])->name('resultados.index');
});
