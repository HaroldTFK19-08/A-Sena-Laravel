<?php

namespace App\Dominios\Areas\Controllers\Api;

use App\Dominios\Areas\Models\Area;
use App\Dominios\Areas\Requests\AreaRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AreaApiController extends ApiController
{
    public function index()
    {
        $areas = Area::with([
            'trainingcenter' => function($consulta){
                $consulta->select('id','nombre');
            }
        ])->get();
        return response()->json($areas);
    }

    public function store(AreaRequest $request): JsonResponse
    {
        $area = Area::create($request->validated());

        return $this->created($area->load('trainingcenter'), 'Área creada correctamente.');
    }

    public function show(int $id)
    {
        $area = Area::with([
                'trainingcenter' => function ($consulta) {
                    $consulta->select('id', 'nombre');
                },
                'programs' => function ($consulta) {
                    $consulta->select('id', 'nombre','area_id');
                }
            ])
            ->findOrFail($id);
        return response()->json($area);
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
