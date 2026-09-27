<?php

use App\Dominios\Inscripciones\Controllers\AspirantRegistrationController;
use App\Dominios\Inscripciones\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::resource('inscripciones', RegistrationController::class);
Route::patch('inscripciones/{inscripcione}/estado', [RegistrationController::class, 'cambiarEstado'])
    ->name('inscripciones.estado');

Route::prefix('aspirante')->name('aspirante.')->group(function () {
    Route::get('ofertas', [AspirantRegistrationController::class, 'ofertas'])->name('ofertas.index');
    Route::get('ofertas/{oferta}', [AspirantRegistrationController::class, 'oferta'])->name('ofertas.show');
    Route::get('resultados', [AspirantRegistrationController::class, 'resultados'])->name('resultados.index');
    Route::get('inscripciones', [AspirantRegistrationController::class, 'index'])->name('inscripciones.index');
    Route::get('inscripciones/crear', [AspirantRegistrationController::class, 'create'])->name('inscripciones.create');
    Route::post('inscripciones', [AspirantRegistrationController::class, 'store'])->name('inscripciones.store');
    Route::get('inscripciones/{inscripcion}', [AspirantRegistrationController::class, 'show'])->name('inscripciones.show');
    Route::get('inscripciones/{inscripcion}/editar', [AspirantRegistrationController::class, 'edit'])->name('inscripciones.edit');
    Route::put('inscripciones/{inscripcion}', [AspirantRegistrationController::class, 'update'])->name('inscripciones.update');
    Route::patch('inscripciones/{inscripcion}/cancelar', [AspirantRegistrationController::class, 'cancelar'])->name('inscripciones.cancelar');
});
