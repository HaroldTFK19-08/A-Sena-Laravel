<?php

namespace App\Dominios\Ambientes\Controllers\Api;

use App\Dominios\Ambientes\Models\Environment;
use App\Dominios\Ambientes\Requests\EnvironmentRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EnvironmentApiController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Environment::query()
            ->with('trainingcenter')
            ->withCount('equipments')
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = trim((string) $request->input('buscar'));
                $query->where(function ($ambientes) use ($buscar) {
                    $ambientes->where('nombre', 'like', "%{$buscar}%")
                        ->orWhereHas('trainingcenter', function ($centros) use ($buscar) {
                            $centros->where('nombre', 'like', "%{$buscar}%");
                        });
                });
            })
            ->when($request->filled('tipo_ambiente'), fn ($query) => $query->where('tipo_ambiente', $request->input('tipo_ambiente')))
            ->orderByDesc('id');

        return $this->paginated($this->applyPagination($query, $request), 'Ambientes obtenidos correctamente.');
    }

    public function store(EnvironmentRequest $request): JsonResponse
    {
        $ambiente = Environment::create($request->validated());

        return $this->created($ambiente->load('trainingcenter'), 'Ambiente creado correctamente.');
    }

    public function show(Environment $ambiente): JsonResponse
    {
        return $this->success($ambiente->load(['trainingcenter', 'equipments']), 'Ambiente obtenido correctamente.');
    }

    public function update(EnvironmentRequest $request, Environment $ambiente): JsonResponse
    {
        $ambiente->update($request->validated());

        return $this->success($ambiente->fresh(['trainingcenter', 'equipments']), 'Ambiente actualizado correctamente.');
    }

    public function destroy(Environment $ambiente): JsonResponse
    {
        $ambiente->delete();

        return $this->success(null, 'Ambiente eliminado correctamente.');
    }
}
