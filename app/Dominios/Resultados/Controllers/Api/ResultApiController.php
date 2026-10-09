<?php

namespace App\Dominios\Resultados\Controllers\Api;

use App\Dominios\Resultados\Models\Result;
use App\Dominios\Resultados\Requests\ResultRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResultApiController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $user = $this->requireRole(['Admin', 'Instructor', 'Aprendiz']);
        $query = Result::query()
            ->with('competition')
            ->withCount('grades')
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = trim((string) $request->input('buscar'));
                $query->where(function ($resultados) use ($buscar) {
                    $resultados->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('codigo', 'like', "%{$buscar}%")
                        ->orWhereHas('competition', function ($competencias) use ($buscar) {
                            $competencias->where('nombre', 'like', "%{$buscar}%");
                        });
                });
            })
            ->when($request->filled('competition_id'), fn ($query) => $query->where('competition_id', $request->integer('competition_id')))
            ->orderByDesc('id');

        if ($user?->rol === 'Instructor') {
            $teacher = $user->teacher;
            $query->whereHas('competition', function ($competencies) use ($teacher) {
                if ($teacher) {
                    $competencies->asignadasAlInstructor($teacher);
                } else {
                    $competencies->whereRaw('1 = 0');
                }
            });
        } elseif ($user?->rol === 'Aprendiz') {
            $query->whereHas('grades.apprentice', function ($apprentices) use ($user) {
                $apprentices->where('user_id', $user->id);
            });
        }

        return $this->paginated($this->applyPagination($query, $request), 'Resultados obtenidos correctamente.');
    }

    public function store(ResultRequest $request): JsonResponse
    {
        $data = $request->validated();
        $cantidad = max(1, (int) ($data['cantidad'] ?? 1));
        unset($data['cantidad']);

        $resultados = collect(range(1, $cantidad))->map(function (int $indice) use ($data, $cantidad) {
            return Result::create([
                ...$data,
                'codigo' => $data['codigo'] ? ($cantidad === 1 ? $data['codigo'] : $data['codigo'].'-'.$indice) : null,
                'nombre' => $cantidad === 1 ? $data['nombre'] : trim($data['nombre'].' '.$indice),
            ]);
        });

        return $this->created(
            $cantidad === 1 ? $resultados->first() : $resultados,
            'Resultado creado correctamente.'
        );
    }

    public function show(Result $resultado): JsonResponse
    {
        return $this->success($this->loadRelations($resultado), 'Resultado obtenido correctamente.');
    }

    public function update(ResultRequest $request, Result $resultado): JsonResponse
    {
        $data = $request->validated();
        unset($data['cantidad']);
        $resultado->update($data);

        return $this->success($this->loadRelations($resultado), 'Resultado actualizado correctamente.');
    }

    public function destroy(Result $resultado): JsonResponse
    {
        if (! $resultado->puedeEliminarse()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar el resultado porque tiene calificaciones asociadas.',
            ], 409);
        }

        $resultado->delete();

        return $this->success(null, 'Resultado eliminado correctamente.');
    }

    private function loadRelations(Result $resultado): Result
    {
        return $resultado->load(['competition', 'grades.apprentice.user', 'grades.teacher.user'])->loadCount('grades');
    }
}
