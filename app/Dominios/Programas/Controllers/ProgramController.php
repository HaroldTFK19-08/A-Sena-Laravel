<?php

namespace App\Dominios\Programas\Controllers;

use App\Dominios\Areas\Models\Area;
use App\Dominios\Programas\Models\Program;
use App\Dominios\Programas\Requests\ProgramRequest;
use App\Http\Controllers\Controller;

class ProgramController extends Controller
{
    public function index()
    {
        $programas = Program::with('area.trainingcenter')->withCount('offerts')->orderByDesc('id')->get();

        return view('Programas.index', compact('programas'));
    }

    public function create()
    {
        $areas = Area::with('trainingcenter')->orderBy('nombre')->get();

        return view('Programas.create', compact('areas'));
    }

    public function store(ProgramRequest $request)
    {
        Program::create($request->validated());

        return redirect()->route('programas.index')->with('success', 'Programa creado correctamente.');
    }

    public function show(Program $programa)
    {
        $programa->load(['area.trainingcenter', 'offerts']);

        return view('Programas.show', compact('programa'));
    }

    public function edit(Program $programa)
    {
        $areas = Area::with('trainingcenter')->orderBy('nombre')->get();

        return view('Programas.edit', compact('programa', 'areas'));
    }

    public function update(ProgramRequest $request, Program $programa)
    {
        $programa->update($request->validated());

        return redirect()->route('programas.index')->with('success', 'Programa actualizado correctamente.');
    }

    public function destroy(Program $programa)
    {
        $programa->delete();

        return redirect()->route('programas.index')->with('success', 'Programa eliminado correctamente.');
    }
}
