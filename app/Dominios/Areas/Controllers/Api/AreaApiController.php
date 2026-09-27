<?php

namespace App\Dominios\Areas\Controllers\Api;

use App\Dominios\Areas\Models\Area;
use App\Dominios\Areas\Requests\AreaRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AreaApiController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Area::query()
            ->with('trainingcenter')
            ->withCount('programs')
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = trim((string) $request->input('buscar'));
                $query->where(function ($areas) use ($buscar) {
                    $areas->where('nombre', 'like', "%{$buscar}%")
                        ->orWhereHas('trainingcenter', function ($centros) use ($buscar) {
                            $centros->where('nombre', 'like', "%{$buscar}%");
                        });
                });
            })
            ->orderByDesc('id');

        return $this->paginated($this->applyPagination($query, $request), 'Áreas obtenidas correctamente.');
    }

    public function store(AreaRequest $request): JsonResponse
    {
        $area = Area::create($request->validated());

        return $this->created($area->load('trainingcenter'), 'Área creada correctamente.');
    }

    public function show(Area $area): JsonResponse
    {
        return $this->success($area->load(['trainingcenter', 'programs']), 'Área obtenida correctamente.');
    }

    public function update(AreaRequest $request, Area $area): JsonResponse
    {
        $area->update($request->validated());

        return $this->success($area->fresh(['trainingcenter', 'programs']), 'Área actualizada correctamente.');
    }

    public function destroy(Area $area): JsonResponse
    {
        $area->delete();

        return $this->success(null, 'Área eliminada correctamente.');
    }
}
