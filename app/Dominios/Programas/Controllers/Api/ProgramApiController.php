<?php

namespace App\Dominios\Programas\Controllers\Api;

use App\Dominios\Programas\Models\Program;
use App\Dominios\Programas\Requests\ProgramRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProgramApiController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Program::query()
            ->with('area.trainingcenter')
            ->withCount('offerts')
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = trim((string) $request->input('buscar'));
                $query->where(function ($programas) use ($buscar) {
                    $programas->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('codigo_programa', 'like', "%{$buscar}%")
                        ->orWhereHas('area', function ($areas) use ($buscar) {
                            $areas->where('nombre', 'like', "%{$buscar}%");
                        });
                });
            })
            ->when($request->filled('nivel_programa'), fn ($query) => $query->where('nivel_programa', $request->input('nivel_programa')))
            ->orderByDesc('id');

        return $this->paginated($this->applyPagination($query, $request), 'Programas obtenidos correctamente.');
    }

    public function store(ProgramRequest $request): JsonResponse
    {
        $programa = Program::create($request->validated());

        return $this->created($programa->load('area.trainingcenter'), 'Programa creado correctamente.');
    }

    public function show(Program $programa): JsonResponse
    {
        return $this->success($programa->load(['area.trainingcenter', 'offerts']), 'Programa obtenido correctamente.');
    }

    public function update(ProgramRequest $request, Program $programa): JsonResponse
    {
        $programa->update($request->validated());

        return $this->success($programa->fresh(['area.trainingcenter', 'offerts']), 'Programa actualizado correctamente.');
    }

    public function destroy(Program $programa): JsonResponse
    {
        $programa->delete();

        return $this->success(null, 'Programa eliminado correctamente.');
    }
}
