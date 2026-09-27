<?php

namespace App\Dominios\Equipos\Controllers\Api;

use App\Dominios\Equipos\Models\Equipment;
use App\Dominios\Equipos\Requests\EquipmentRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EquipmentApiController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Equipment::query()
            ->with('environment.trainingcenter')
            ->withCount('assignments')
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = trim((string) $request->input('buscar'));
                $query->where(function ($equipos) use ($buscar) {
                    $equipos->where('name', 'like', "%{$buscar}%")
                        ->orWhere('brand', 'like', "%{$buscar}%")
                        ->orWhere('equipment_type', 'like', "%{$buscar}%");
                });
            })
            ->orderByDesc('id');

        return $this->paginated($this->applyPagination($query, $request), 'Equipos obtenidos correctamente.');
    }

    public function store(EquipmentRequest $request): JsonResponse
    {
        $equipo = Equipment::create($request->validated());

        return $this->created($equipo->load('environment.trainingcenter'), 'Equipo creado correctamente.');
    }

    public function show(Equipment $equipo): JsonResponse
    {
        return $this->success($equipo->load(['environment.trainingcenter', 'assignments']), 'Equipo obtenido correctamente.');
    }

    public function update(EquipmentRequest $request, Equipment $equipo): JsonResponse
    {
        $equipo->update($request->validated());

        return $this->success($equipo->fresh(['environment.trainingcenter', 'assignments']), 'Equipo actualizado correctamente.');
    }

    public function destroy(Equipment $equipo): JsonResponse
    {
        $equipo->delete();

        return $this->success(null, 'Equipo eliminado correctamente.');
    }
}
