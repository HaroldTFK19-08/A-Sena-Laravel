<?php

namespace App\Dominios\Fichas\Controllers;

use App\Dominios\Fichas\Models\Course_group;
use App\Dominios\Fichas\Requests\CourseGroupRequest;
use App\Dominios\Programas\Models\Program;
use App\Dominios\Usuarios\Models\Teacher;
use App\Http\Controllers\Controller;

class CourseGroupController extends Controller
{
    public function index()
    {
        $fichas = Course_group::with(['program', 'teachers.user'])->latest()->get();
        return view('Fichas.index', compact('fichas'));
    }

    public function create()
    {
        return view('Fichas.create', [
            'programas' => Program::orderBy('nombre')->get(),
            'instructores' => Teacher::with(['user', 'area'])->get(),
        ]);
    }

    public function store(CourseGroupRequest $request)
    {
        $data = $request->validated();
        $teacherId = $data['teacher_id'];

        $ficha = Course_group::create($data);
        $ficha->teachers()->attach($teacherId);

        return redirect()->route('fichas.index')->with('success', 'Ficha creada correctamente.');
    }

    public function show(Course_group $ficha)
    {
        $ficha->load(['program', 'teachers.user', 'apprentices.user']);
        return view('Fichas.show', compact('ficha'));
    }

    public function edit(Course_group $ficha)
    {
        return view('Fichas.edit', [
            'ficha' => $ficha,
            'programas' => Program::orderBy('nombre')->get(),
            'instructores' => Teacher::with(['user', 'area'])->get(),
        ]);
    }

    public function update(CourseGroupRequest $request, Course_group $ficha)
    {
        $data = $request->validated();
        $teacherId = $data['teacher_id'];

        $ficha->update($data);
        $ficha->teachers()->sync([$teacherId]);

        return redirect()->route('fichas.index')->with('success', 'Ficha actualizada correctamente.');
    }

    public function destroy(Course_group $ficha)
    {
        $ficha->delete();

        return redirect()->route('fichas.index')->with('success', 'Ficha eliminada correctamente.');
    }
}