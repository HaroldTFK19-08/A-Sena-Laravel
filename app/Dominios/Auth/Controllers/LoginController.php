<?php

namespace App\Dominios\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Dominios\Auth\Requests\LoginRequest;
use App\Dominios\Usuarios\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credenciales = $request->validated();

        if (Auth::attempt($credenciales)) {

            $request->session()->regenerate();

            $usuario = Auth::user();

            return $this->redireccionRol($usuario);
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ])->onlyInput('email');
    }

    public function redireccionRol(User $usuario)
    {
        return match ($usuario->rol) {
            'Aprendiz' => redirect()->route('aprendiz.home'),
            'Instructor' => redirect()->route('instructor.home'),
            'Admin' => redirect()->route('admin.home'),
            'Aspirante' => redirect()->route('aspirante.home'),
            default => abort(403, 'Rol no válido'),
        };
    }
}