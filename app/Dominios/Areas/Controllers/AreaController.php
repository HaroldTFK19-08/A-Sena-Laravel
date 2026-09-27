<?php

namespace App\Dominios\Areas\Controllers;

use App\Dominios\Areas\Models\Area;
use App\Dominios\Areas\Requests\AreaRequest;
use App\Dominios\Centros\Models\Trainingcenter;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::with('trainingcenter')->withCount('programs')->orderByDesc('id')->get();

        return view('Areas.index', compact('areas'));
    }

    public function create()
    {
        $centros = Trainingcenter::orderBy('nombre')->get();

        return view('Areas.create', compact('centros'));
    }

    public function store(AreaRequest $request)
    {
        Area::create($request->validated());

        return redirect()->route('areas.index')->with('success', 'Área creada correctamente.');
    }

    public function show(Area $area)
    {
        $area->load(['trainingcenter', 'programs']);

        return view('Areas.show', compact('area'));
    }

    public function edit(Area $area)
    {
        $centros = Trainingcenter::orderBy('nombre')->get();

        return view('Areas.edit', compact('area', 'centros'));
    }

    public function update(AreaRequest $request, Area $area)
    {
        $area->update($request->validated());

        return redirect()->route('areas.index')->with('success', 'Área actualizada correctamente.');
    }

    public function destroy(Area $area)
    {
        $area->delete();

        return redirect()->route('areas.index')->with('success', 'Área eliminada correctamente.');
    }
}
