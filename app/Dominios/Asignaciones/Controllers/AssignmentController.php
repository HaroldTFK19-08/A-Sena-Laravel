<?php

namespace App\Dominios\Asignaciones\Controllers;

use App\Dominios\Asignaciones\Models\Assignment;
use App\Dominios\Asignaciones\Requests\AssignmentRequest;
use App\Dominios\Equipos\Models\Equipment;
use App\Dominios\Usuarios\Models\Apprentice;
use App\Dominios\Usuarios\Models\Teacher;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class AssignmentController extends Controller
{
    public function index()
    {
        $isInstructor = auth()->user()?->rol === 'Instructor';
        $asignaciones = $this->queryVisibles()
            ->latest()
            ->get();
        $baseRoute = $isInstructor ? 'instructor.asignaciones' : 'admin.asignaciones';

        return view('Asignaciones.index', compact('asignaciones', 'isInstructor', 'baseRoute'));
    }

    public function create()
    {
        $aprendices = $this->aprendicesVisiblesQuery()
            ->with('coursegroup.program')
            ->get();
        $equipos = Equipment::with('environment')->get();

        return view('Asignaciones.create', compact('aprendices', 'equipos'));
    }

    public function store(AssignmentRequest $request)
    {
        $datos = $request->validated();
        $this->autorizarAprendiz(Apprentice::findOrFail($datos['apprentice_id']));

        Assignment::create($datos);

        return redirect()->route('instructor.asignaciones.index')->with('success', 'Asignación registrada correctamente.');
    }

    public function show(Assignment $assignment)
    {
        $this->autorizarAsignacion($assignment);
        $assignment->load(['apprentice.user', 'apprentice.coursegroup', 'equipment.environment']);

        return view('Asignaciones.show', compact('assignment'));
    }

    public function edit(Assignment $assignment)
    {
        $this->autorizarAsignacion($assignment);
        $aprendices = $this->aprendicesVisiblesQuery()
            ->with('coursegroup')
            ->get();
        $equipos = Equipment::with('environment')->get();

        return view('Asignaciones.edit', compact('assignment', 'aprendices', 'equipos'));
    }

    public function update(AssignmentRequest $request, Assignment $assignment)
    {
        $this->autorizarAsignacion($assignment);
        $datos = $request->validated();
        $this->autorizarAprendiz(Apprentice::findOrFail($datos['apprentice_id']));

        $assignment->update($datos);

        return redirect()->route('instructor.asignaciones.index')->with('success', 'Asignación actualizada correctamente.');
    }

    public function destroy(Assignment $assignment)
    {
        $this->autorizarAsignacion($assignment);
        $assignment->delete();

        return redirect()->route('instructor.asignaciones.index')->with('success', 'Asignación eliminada correctamente.');
    }

    private function queryVisibles(): Builder
    {
        $query = Assignment::query()->with(['apprentice.user', 'equipment.environment']);

        if (auth()->user()?->rol === 'Admin') {
            return $query;
        }

        $instructor = auth()->user()?->teacher;
        if (! $instructor) {
            return $query->whereRaw('1 = 0');
        }

        return $query->whereHas('apprentice.coursegroup', function ($coursegroups) use ($instructor) {
            $coursegroups->asignadasAlInstructor($instructor);
        });
    }

    private function aprendicesVisiblesQuery(): Builder
    {
        $query = Apprentice::query()->with('user');

        if (auth()->user()?->rol === 'Admin') {
            return $query;
        }

        $instructor = $this->instructorActual();

        return $query->whereHas('coursegroup', function ($coursegroups) use ($instructor) {
            $coursegroups->asignadasAlInstructor($instructor);
        });
    }

    private function autorizarAprendiz(Apprentice $aprendiz): void
    {
        if (auth()->user()?->rol === 'Admin') {
            return;
        }

        $instructor = $this->instructorActual();
        abort_unless($aprendiz->coursegroup && $aprendiz->coursegroup->estaAsignadaAlInstructor($instructor), 403);
    }

    private function autorizarAsignacion(Assignment $assignment): void
    {
        if (auth()->user()?->rol === 'Admin') {
            return;
        }

        $instructor = $this->instructorActual();
        $visible = $this->queryVisibles()->whereKey($assignment->id)->exists();
        abort_unless($visible, 403, 'No tienes acceso a esta asignación.');
    }

    private function instructorActual(): Teacher
    {
        $instructor = auth()->user()?->teacher;
        abort_unless($instructor, 403, 'Debes completar tu perfil de instructor para continuar.');

        return $instructor;
    }
}
