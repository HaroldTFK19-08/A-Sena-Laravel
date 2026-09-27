<?php

namespace App\Dominios\Auth\Controllers;

use App\Dominios\Auth\Requests\LoginRequest;
use App\Dominios\Usuarios\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
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
        $ruta = RouteServiceProvider::ROLE_HOME[$usuario->rol] ?? null;
        abort_if($ruta === null, 403, 'Rol no válido');
        return redirect()->route($ruta);
    }
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('auth.inicio')->with('success', 'Sesión finalizada correctamente.');
    }
}
