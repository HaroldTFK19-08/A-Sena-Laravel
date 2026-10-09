<?php

namespace App\Dominios\Ambientes\Controllers\Api;

use App\Dominios\Ambientes\Models\Environment;
use App\Dominios\Ambientes\Requests\EnvironmentRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class EnvironmentApiController extends ApiController
{
    public function index(Request $request)
    {
        $ambientes = Environment::latest()->get();
        return response()->json($ambientes);
    }

    public function store(EnvironmentRequest $request)
    {
        $ambiente = Environment::create($request->validated());
        return response()->json($ambiente);
    }
    public function show(int $id)
    {
        $ambiente = Environment::with([
            'trainingcenter',
            'equipments' => function ($query) {
                $query->select('id', 'name', 'brand', 'equipment_type', 'environment_id');
            }
        ])->findOrFail($id);
        return response()->json($ambiente);
    }
    public function update(EnvironmentRequest $request, Environment $ambiente)
    {
        $ambiente->update($request->validated());
        return response()->json($ambiente);
    }

    public function destroy(Environment $ambiente)
    {
        $ambiente->delete();
        return response()->json($ambiente);
    }
}
