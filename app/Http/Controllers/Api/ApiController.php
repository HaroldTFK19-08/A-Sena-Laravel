<?php

namespace App\Http\Controllers\Api;

use App\Dominios\Usuarios\Models\Admin;
use App\Dominios\Usuarios\Models\User;
use App\Http\Controllers\Controller;
use App\Support\Concerns\ResolvesApiUser;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class ApiController extends Controller
{
    use ResolvesApiUser;

    protected function success(mixed $data = null, string $message = 'Operación realizada correctamente.', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    protected function created(mixed $data = null, string $message = 'Registro creado correctamente.', int $status = 201): JsonResponse
    {
        return $this->success($data, $message, $status);
    }

    protected function paginated(LengthAwarePaginator $paginator, string $message = 'Listado obtenido correctamente.'): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'from' => $paginator->firstItem(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'to' => $paginator->lastItem(),
                'total' => $paginator->total(),
            ],
        ]);
    }

    /**
     * Usuario de la petición si su rol está permitido.
     *
     * En modo práctica (`config('adminsena.practice_mode')`) devuelve `null`
     * cuando no llega un token válido, de modo que el controlador opera sin
     * alcance de usuario en lugar de abortar con `403`.
     */
    protected function requireRole(string|array $roles): ?User
    {
        return $this->resolveApiRole($roles);
    }

    protected function requireAdmin(): ?User
    {
        return $this->requireRole('Admin');
    }

    /**
     * Perfil de administrador usado en las tablas que exigen `admin_id`.
     *
     * Con token usa el del usuario; sin token (modo práctica) toma el primer
     * administrador registrado para que el registro pueda guardarse.
     */
    protected function adminProfileId(?User $user = null): int
    {
        $adminId = $user?->admin?->id ?? Admin::query()->orderBy('id')->value('id');

        abort_if(! $adminId, 422, 'No hay un perfil de administrador disponible para completar la operación.');

        return (int) $adminId;
    }

    /**
     * Usuario actual de la petición, resuelto a partir del token Bearer.
     */
    protected function currentUser(): ?User
    {
        return $this->resolveApiUser();
    }

    protected function applyPagination($query, Request $request, int $perPage = 15)
    {
        return $query->paginate(min(100, max(1, (int) $request->integer('per_page', $perPage))))
            ->withQueryString();
    }
}
