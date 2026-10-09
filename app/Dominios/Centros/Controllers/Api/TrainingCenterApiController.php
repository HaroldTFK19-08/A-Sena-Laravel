<?php

namespace App\Dominios\Centros\Controllers\Api;

use App\Dominios\Centros\Models\Trainingcenter;
use App\Dominios\Centros\Requests\TrainingcentersRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrainingCenterApiController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Trainingcenter::query()
            ->withCount(['areas', 'environments'])
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = trim((string) $request->input('buscar'));
                $query->where(function ($centros) use ($buscar) {
                    $centros->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('direccion', 'like', "%{$buscar}%");
                });
            })
            ->orderByDesc('id');
        return $this->paginated($this->applyPagination($query, $request), 'Centros obtenidos correctamente.');
    }
    public function store(TrainingcentersRequest $request): JsonResponse
    {
        $centro = Trainingcenter::create($request->validated());
        return $this->created($centro->loadCount(['areas', 'environments']), 'Centro creado correctamente.');
    }
    public function show(Trainingcenter $centro): JsonResponse
    {
        return $this->success($centro->load(['areas', 'environments']), 'Centro obtenido correctamente.');
    }
    public function update(TrainingcentersRequest $request, Trainingcenter $centro): JsonResponse
    {
        $centro->update($request->validated());
        return $this->success($centro->fresh(['areas', 'environments']), 'Centro actualizado correctamente.');
    }
    public function destroy(Trainingcenter $centro): JsonResponse
    {
        $centro->delete();
        return $this->success(null, 'Centro eliminado correctamente.');
    }
}
