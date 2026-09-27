<?php

namespace App\Dominios\Competencias\Controllers;

use App\Dominios\Competencias\Models\Competition;
use App\Dominios\Competencias\Requests\CompetitionRequest;
use App\Dominios\Usuarios\Models\Teacher;
use App\Http\Controllers\Controller;

class CompetitionController extends Controller
{
    public function index()
    {
        $competencias = Competition::with('teachers')->latest()->get();
        return view('Competencias.index', compact('competencias'));
    }
    public function create()
    {
        return view('Competencias.create', [
            'instructores' => Teacher::with('user')->get(),
        ]);
    }
    public function store(CompetitionRequest $request)
    {
        $datos = $request->validated();
        // Sacamos los instructores porque no pertenecen
        // directamente a la tabla competencies
        $instructores = $datos['teachers'] ?? [];
        unset($datos['teachers']);
        // Creamos la competencia
        $competencia = Competition::create($datos);
        // Guardamos la relación N:M
        $competencia->teachers()->sync($instructores);
        return redirect()
            ->route('competencias.index')
            ->with('success', 'Competencia creada correctamente.');
    }
    public function show(Competition $competencia)
    {
        $competencia->load('teachers');
        return view('Competencias.show', compact('competencia'));
    }
    public function edit(Competition $competencia)
    {
        $competencia->load('teachers');
        return view('Competencias.edit', [
            'competencia' => $competencia,
            'instructores' => Teacher::with('user')->get(),
        ]);
    }
    public function update(
        CompetitionRequest $request,
        Competition $competencia
    ) {
        $datos = $request->validated();
        // Sacamos los instructores
        $instructores = $datos['teachers'] ?? [];
        unset($datos['teachers']);
        // Actualizamos la competencia
        $competencia->update($datos);
        // Actualizamos los instructores relacionados
        $competencia->teachers()->sync($instructores);
        return redirect()
            ->route('competencias.index')
            ->with('success', 'Competencia actualizada correctamente.');
    }
    public function destroy(Competition $competencia)
    {
        $competencia->delete();
        return redirect()
            ->route('competencias.index')
            ->with('success', 'Competencia eliminada correctamente.');
    }
}