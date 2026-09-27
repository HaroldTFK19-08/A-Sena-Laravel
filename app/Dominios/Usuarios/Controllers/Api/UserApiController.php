<?php

namespace App\Dominios\Usuarios\Controllers\Api;

use App\Dominios\Usuarios\Models\User;
use App\Dominios\Usuarios\Requests\UserApiRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserApiController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $query = User::query()
            ->with(['admin', 'teacher', 'apprentice', 'aspirant'])
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = trim((string) $request->input('buscar'));
                $query->where(function ($usuarios) use ($buscar) {
                    $usuarios->where('nombre_1', 'like', "%{$buscar}%")
                        ->orWhere('nombre_2', 'like', "%{$buscar}%")
                        ->orWhere('apellido_1', 'like', "%{$buscar}%")
                        ->orWhere('apellido_2', 'like', "%{$buscar}%")
                        ->orWhere('identificacion', 'like', "%{$buscar}%")
                        ->orWhere('email', 'like', "%{$buscar}%");
                });
            })
            ->when($request->filled('rol'), fn ($query) => $query->where('rol', $request->input('rol')))
            ->latest('id');

        return $this->paginated($this->applyPagination($query, $request), 'Usuarios obtenidos correctamente.');
    }

    public function store(UserApiRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['foto_perfil'] = $request->file('foto_perfil')?->store('photos', 'public');
        $user = User::create($data);

        return $this->created($this->loadRelations($user), 'Usuario creado correctamente.');
    }

    public function show(User $usuario): JsonResponse
    {
        $this->requireAdmin();

        return $this->success($this->loadRelations($usuario), 'Usuario obtenido correctamente.');
    }

    public function update(UserApiRequest $request, User $usuario): JsonResponse
    {
        $this->requireAdmin();
        $data = $request->validated();

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password'], $data['password_confirmation']);
        }

        if ($request->hasFile('foto_perfil')) {
            $data['foto_perfil'] = $request->file('foto_perfil')->store('photos', 'public');
        }

        $usuario->update($data);

        return $this->success($this->loadRelations($usuario->fresh()), 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario): JsonResponse
    {
        $this->requireAdmin();
        abort_if($usuario->id === $this->currentUser()?->id, 422, 'No puedes eliminar tu propio usuario.');

        $usuario->delete();

        return $this->success(null, 'Usuario eliminado correctamente.');
    }

    private function loadRelations(User $user): User
    {
        return $user->load(['admin', 'teacher.area', 'apprentice.coursegroup', 'aspirant']);
    }
}
