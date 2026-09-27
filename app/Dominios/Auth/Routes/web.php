<?php

use App\Dominios\Auth\Controllers\LoginController;
use App\Dominios\Auth\Controllers\OfertasyNoticiasController;
use App\Dominios\Auth\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [OfertasyNoticiasController::class, 'previa'])->name('auth.inicio');

// El acceso a la sesión se abre únicamente para usuarios NO autenticados.
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('Auth.login');
    })->name('auth.login');
    Route::post('/login', [LoginController::class, 'login'])->name('auth.login.submit');
    Route::get('/register', function () {
        return view('Auth.register');
    })->name('auth.register');
    Route::post('/register', [RegisterController::class, 'register'])->name('auth.register.submit');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('auth.logout');

Route::get('/noticias-publicas', [OfertasyNoticiasController::class, 'noticias'])
    ->name('auth.noticias');
Route::get('/noticias-publicas/buscar', [OfertasyNoticiasController::class, 'buscarNoticias'])
    ->name('auth.noticias.buscar');
Route::get('/noticias-publicas/{noticia}', [OfertasyNoticiasController::class, 'noticia'])
    ->whereNumber('noticia')
    ->name('auth.noticias.show');
Route::get('/ofertas-publicas', [OfertasyNoticiasController::class, 'ofertas'])
    ->name('auth.ofertas');
Route::get('/ofertas-publicas/buscar', [OfertasyNoticiasController::class, 'buscarOfertas'])
    ->name('auth.ofertas.buscar');
Route::get('/ofertas-publicas/{oferta}', [OfertasyNoticiasController::class, 'oferta'])
    ->whereNumber('oferta')
    ->name('auth.ofertas.show');
