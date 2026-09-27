<?php

namespace App\Dominios\Equipos\Controllers;

use App\Dominios\Ambientes\Models\Environment;
use App\Dominios\Equipos\Models\Equipment;
use App\Dominios\Equipos\Requests\EquipmentRequest;
use App\Http\Controllers\Controller;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipos = Equipment::orderByDesc('id','desc')->get();
        return view('Equipos.index', compact('equipos'));
    }
    public function create()
    {
        $ambientes = Environment::with('trainingcenter')->orderBy('nombre')->get();
        return view('Equipos.create', compact('ambientes'));
    }
    public function store(EquipmentRequest $request)
    {
        Equipment::create($request->validated());
        return redirect()->route('equipos.index')->with('success', 'Equipo creado correctamente.');
    }
    public function show(Equipment $equipo)
    {
        $equipo->load(['environment.trainingcenter']);
        return view('Equipos.show', compact('equipo'));
    }

    public function edit(Equipment $equipo)
    {
        $ambientes = Environment::with('trainingcenter')->orderBy('nombre')->get();
        return view('Equipos.edit', compact('equipo', 'ambientes'));
    }

    public function update(EquipmentRequest $request, Equipment $equipo){
        $equipo->update($request->validated());
        return redirect()->route('equipos.index')->with('success', 'Equipo actualizado correctamente.');
    }

    public function destroy(Equipment $equipo)
    {
        $equipo->delete();
        return redirect()->route('equipos.index')->with('success', 'Equipo eliminado correctamente.');
    }
}
