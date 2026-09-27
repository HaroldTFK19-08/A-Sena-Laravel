<?php

namespace App\Dominios\Ambientes\Controllers;

use App\Http\Controllers\Controller;
use App\Dominios\Ambientes\Models\Environment;
use App\Dominios\Centros\Models\Trainingcenter;
use App\Dominios\Ambientes\Requests\EnvironmentRequest;

class EnvironmentController extends Controller
{
    //
    public function create(){
        $centros = Trainingcenter::all();
        return view('Ambientes.create',compact('centros'));
    }
    public function store(EnvironmentRequest $request){
        Environment::create($request->validated());
        return redirect()->route('ambientes.index');
    } 
    public function index(){
        $ambientes = Environment::with('trainingcenter')->orderBy('id','desc')->get();
        return view('Ambientes.index',compact('ambientes'));
    }
    public function show(int $id){
        $ambiente = Environment::with(['trainingcenter'])->findOrFail($id);
        return view('Ambientes.show',compact('ambiente'));
    }
    public function edit(Environment $ambiente){
        $centros = Trainingcenter::all();
        return view('Ambientes.edit',compact('centros','ambiente'));
    }
    public function update(EnvironmentRequest $request, Environment $ambiente){
        $ambiente->update($request->validated());
        return redirect()->route('ambientes.index');
    }
    public function destroy(Environment $ambiente){
        $ambiente->delete();
        return redirect()->route('ambientes.index');
    }
}
