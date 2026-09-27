<?php

namespace App\Http\Controllers\Api;

use App\Dominios\Usuarios\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class ApiController extends Controller
{
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

    protected function requireRole(string|array $roles): User
    {
        $roles = (array) $roles;
        $user = $this->currentUser();

        abort_unless($user && in_array($user->rol, $roles, true), 403, 'No tienes permisos para realizar esta acción.');

        return $user;
    }

    protected function requireAdmin(): User
    {
        return $this->requireRole('Admin');
    }

    protected function currentUser(): ?User
    {
        $user = request()->user();

        return $user instanceof User ? $user : null;
    }

    protected function applyPagination($query, Request $request, int $perPage = 15)
    {
        return $query->paginate(min(100, max(1, (int) $request->integer('per_page', $perPage))))
            ->withQueryString();
    }
}
