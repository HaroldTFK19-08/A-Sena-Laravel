<?php

namespace App\Dominios\Centros\Controllers;

use App\Http\Controllers\Controller;
use App\Dominios\Centros\Models\Trainingcenter;
use App\Dominios\Centros\Requests\TrainingcentersRequest;

class ApiController extends Controller
{
    //
    public function index(){
        $centros = Trainingcenter::orderBy('id','desc')->get();
        return response()->json($centros);
    }
    public function store(TrainingcentersRequest $request){
        $registro = Trainingcenter::create($request->validated());
        return response()->json($registro);
    }
    public function show(int $id){
        $centro = Trainingcenter::findOrFail($id);
        return response()->json($centro);
    }
    public function update(TrainingcentersRequest $request, Trainingcenter $centro){
        $centro->update($request->validated());
        return response()->json($centro);
    }
    public function destroy(Trainingcenter $centro){
        $centro->delete();
        return response()->json($centro);
    }
}
