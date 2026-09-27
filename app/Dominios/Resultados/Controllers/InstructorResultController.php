<?php

namespace App\Dominios\Resultados\Controllers;

use App\Dominios\Competencias\Models\Competition;
use App\Dominios\Fichas\Models\Course_group;
use App\Dominios\Resultados\Models\Grade;
use App\Dominios\Resultados\Requests\GradeRequest;
use App\Dominios\Usuarios\Models\Teacher;
use App\Http\Controllers\Controller;

class InstructorResultController extends Controller
{
    public function index()
    {
        $instructor = $this->instructorActual();

        $fichas = Course_group::query()
            ->asignadasAlInstructor($instructor)
            ->with(['program', 'apprentices.user'])
            ->withCount('apprentices')
            ->latest()
            ->get();

        $competencias = Competition::query()
            ->asignadasAlInstructor($instructor)
            ->withCount('results')
            ->orderBy('nombre')
            ->get();

        $resumen = [
            'fichas' => $fichas->count(),
            'aprendices' => $fichas->sum('apprentices_count'),
            'competencias' => $competencias->count(),
        ];

        return view('Resultados.Instructor.index', compact('fichas', 'competencias', 'resumen'));
    }

    public function ficha(Course_group $ficha)
    {
        $instructor = $this->instructorActual();
        abort_unless($ficha->estaAsignadaAlInstructor($instructor), 403);

        $ficha->load(['program', 'apprentices.user', 'apprentices.grades.result']);

        $competencias = Competition::query()
            ->asignadasAlInstructor($instructor)
            ->with('results')
            ->orderBy('nombre')
            ->get();

        return view('Resultados.Instructor.ficha', compact('ficha', 'competencias'));
    }

    public function calificar(Course_group $ficha, Competition $competencia)
    {
        $instructor = $this->instructorActual();
        abort_unless($ficha->estaAsignadaAlInstructor($instructor), 403);
        abort_unless($competencia->estaAsignadaAlInstructor($instructor), 403);

        $ficha->load(['program', 'apprentices.user']);
        $competencia->load('results');

        $calificaciones = Grade::query()
            ->whereIn('result_id', $competencia->results->pluck('id'))
            ->whereIn('apprentice_id', $ficha->apprentices->pluck('id'))
            ->get()
            ->keyBy(fn (Grade $grade) => $grade->apprentice_id.'-'.$grade->result_id);

        return view('Resultados.Instructor.calificar', compact('ficha', 'competencia', 'calificaciones'));
    }

    public function guardar(GradeRequest $request, Course_group $ficha, Competition $competencia)
    {
        $instructor = $this->instructorActual();
        abort_unless($ficha->estaAsignadaAlInstructor($instructor), 403);
        abort_unless($competencia->estaAsignadaAlInstructor($instructor), 403);

        $aprendicesPermitidos = $ficha->apprentices()->pluck('id');
        $resultadosPermitidos = $competencia->results()->pluck('id');

        foreach ($request->validated()['calificaciones'] as $calificacion) {
            abort_unless($aprendicesPermitidos->contains((int) $calificacion['apprentice_id']), 403);
            abort_unless($resultadosPermitidos->contains((int) $calificacion['result_id']), 403);

            Grade::updateOrCreate(
                [
                    'result_id' => $calificacion['result_id'],
                    'apprentice_id' => $calificacion['apprentice_id'],
                ],
                [
                    'teacher_id' => $instructor->id,
                    'estado_resultado' => $calificacion['estado_resultado'],
                    'comentarios' => $calificacion['comentarios'] ?? null,
                ]
            );
        }

        return redirect()
            ->route('instructor.resultados.ficha', $ficha)
            ->with('success', 'Calificaciones registradas correctamente.');
    }

    private function instructorActual(): Teacher
    {
        $instructor = auth()->user()?->teacher;
        abort_unless($instructor, 403, 'Debes completar tu perfil de instructor para continuar.');

        return $instructor;
    }
}
