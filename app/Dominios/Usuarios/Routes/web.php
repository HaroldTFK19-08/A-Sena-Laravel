<?php

use App\Dominios\Asignaciones\Controllers\ApprenticeAssignmentController;
use App\Dominios\Usuarios\Controllers\AdminController;
use App\Dominios\Usuarios\Controllers\AprendizController;
use App\Dominios\Usuarios\Controllers\AspiranteController;
use App\Dominios\Usuarios\Controllers\ConsultasController;
use App\Dominios\Usuarios\Controllers\InstructorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('home', [AdminController::class, 'home'])->name('home');
    Route::get('perfil', [AdminController::class, 'perfil'])->name('perfil');
    Route::get('edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('update', [AdminController::class, 'update'])->name('update');
    Route::get('usuarios', [ConsultasController::class, 'usuarios'])->name('usuarios');
    Route::get('filtrar', [ConsultasController::class, 'filtrarUsuarios'])->name('filtrar');
});

Route::middleware(['auth', 'aprendiz'])->prefix('aprendiz')->name('aprendiz.')->group(function () {
    Route::get('home', [AprendizController::class, 'home'])->name('home');
    Route::get('perfil', [AprendizController::class, 'perfil'])->name('perfil');
    Route::get('edit', [AprendizController::class, 'edit'])->name('edit');
    Route::put('update', [AprendizController::class, 'update'])->name('update');
    Route::get('ficha', [AprendizController::class, 'ficha'])->name('ficha');
    Route::get('asignaciones', [ApprenticeAssignmentController::class, 'index'])->name('asignaciones.index');
    Route::get('asignaciones/{assignment}', [ApprenticeAssignmentController::class, 'show'])->name('asignaciones.show');
    Route::get('cronograma', [AprendizController::class, 'cronograma'])->name('cronograma');
});

Route::middleware(['auth', 'instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('home', [InstructorController::class, 'home'])->name('home');
    Route::get('perfil', [InstructorController::class, 'perfil'])->name('perfil');
    Route::get('edit', [InstructorController::class, 'edit'])->name('edit');
    Route::put('update', [InstructorController::class, 'update'])->name('update');
    Route::get('aprendices', [InstructorController::class, 'aprendices'])->name('aprendices');
    Route::get('fichas', [InstructorController::class, 'fichas'])->name('fichas');
    Route::get('fichas/{ficha}', [InstructorController::class, 'fichaShow'])->name('fichas.show');
    Route::get('actividades', [InstructorController::class, 'actividades'])->name('actividades');
    Route::get('agenda', [InstructorController::class, 'agenda'])->name('agenda');
});

Route::middleware(['auth', 'aspirante'])->prefix('aspirante')->name('aspirante.')->group(function () {
    Route::get('home', [AspiranteController::class, 'home'])->name('home');
    Route::get('perfil', [AspiranteController::class, 'perfil'])->name('perfil');
    Route::get('edit', [AspiranteController::class, 'edit'])->name('edit');
    Route::put('update', [AspiranteController::class, 'update'])->name('update');
    Route::get('fechas', [AspiranteController::class, 'fechas'])->name('fechas');
});
