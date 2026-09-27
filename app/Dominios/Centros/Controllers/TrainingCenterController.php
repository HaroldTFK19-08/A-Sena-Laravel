<?php

namespace App\Dominios\Centros\Controllers;

use App\Http\Controllers\Controller;
use App\Dominios\Centros\Models\Trainingcenter;
use App\Dominios\Centros\Requests\TrainingcentersRequest;

class TrainingCenterController extends Controller
{
    //
    public function create(){
        return view('Centros.create');
    }
    public function store(TrainingcentersRequest $request){
        Trainingcenter::create($request->validated());
        return redirect()->route('centros.index');
    }
    public function index(){
        $centros = Trainingcenter::orderBy("id","desc")->get();
        return view("Centros.index",compact('centros'));
    }
    public function show(int $id){
        $centro = Trainingcenter::findOrFail($id);
        return view ("Centros.show",compact('centro'));
    }
    public function edit(Trainingcenter $centro){
        return view('Centros.edit',compact('centro'));
    }
    public function update(TrainingcentersRequest $request, Trainingcenter $centro){
        $centro->update($request->validated());
        return redirect()->route('centros.index');
    }
    public function destroy(Trainingcenter $centro){
        $centro->delete();
        return redirect()->route('centros.index');
    }
}
