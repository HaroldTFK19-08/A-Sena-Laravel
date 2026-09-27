<?php

namespace App\Dominios\Usuarios\Controllers;

use App\Http\Controllers\Controller;
use App\Dominios\Usuarios\Models\User;
use Illuminate\Http\Request;

class ConsultasController extends Controller
{
    private array $rolesPermitidos = ['Instructor', 'Aprendiz', 'Aspirante'];

    public function usuarios()
    {
        $usuarios = User::whereIn('rol', $this->rolesPermitidos)
            ->latest()
            ->paginate(10);

        return view('Usuarios.Admin.usuarios', compact('usuarios'));
    }

    public function filtrarUsuarios(Request $request)
    {
        $usuarios = User::query()
            // Restricción base: solo estos 3 roles
            ->whereIn('rol', $this->rolesPermitidos)
            // Filtro por término de búsqueda
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = $request->buscar;
                $query->where(function ($q) use ($buscar) {
                    $q->where('nombre_1', 'like', "%{$buscar}%")
                        ->orWhere('nombre_2', 'like', "%{$buscar}%")
                        ->orWhere('apellido_1', 'like', "%{$buscar}%")
                        ->orWhere('apellido_2', 'like', "%{$buscar}%")
                        ->orWhere('identificacion', 'like', "%{$buscar}%")
                        ->orWhere('email', 'like', "%{$buscar}%");
                });
            })
            // Filtro por rol específico (siempre dentro de los permitidos)
            ->when($request->filled('rol'), function ($query) use ($request) {
                $query->where('rol', $request->rol);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // Conserva automáticamente todos los parámetros en la paginación
        return view('Usuarios.Admin.usuarios', compact('usuarios'));
    }
}
