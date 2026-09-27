<?php

namespace App\Dominios\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Dominios\Auth\Requests\RegisterRequest;
use App\Dominios\Usuarios\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //registro de usuario
    public function register(RegisterRequest $request){
        $datos = $request->validated();
        if ($request->hasFile('foto_perfil')) {
            $datos['foto_perfil'] = $request->file('foto_perfil')->store('photos', 'public');
        }
        $datos['password'] = Hash::make($datos['password']);
        User::create($datos);
        return redirect()->route('auth.login');
    }
}
