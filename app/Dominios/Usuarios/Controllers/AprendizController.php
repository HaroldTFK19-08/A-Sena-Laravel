<?php

namespace App\Dominios\Usuarios\Controllers;

use App\Dominios\Competencias\Models\Competition;
use App\Dominios\Fichas\Models\Course_group;
use App\Dominios\Usuarios\Models\User;
use App\Dominios\Usuarios\Requests\PerfilAprendizRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AprendizController extends Controller
{
    public function home()
    {
        /** @var User $usuario */
        $usuario = auth()->user();
        $aprendiz = $usuario->apprentice()->with(['coursegroup', 'assignments', 'grades'])->first();

        $totalAsignaciones = $aprendiz?->assignments->count() ?? 0;
        $totalResultados = $aprendiz?->grades->count() ?? 0;
        $resultadosEvaluados = $aprendiz?->grades
            ->where('estado_resultado', '!=', 'Pendiente')
            ->count() ?? 0;
        $progreso = $totalResultados > 0
            ? (int) round(($resultadosEvaluados / $totalResultados) * 100)
            : 0;

        return view('Usuarios.Aprendices.homeAprendiz', [
            'nombre_1' => $usuario->nombre_1 ?? 'Aprendiz',
            'aprendiz' => $aprendiz,
            'totalFichas' => $aprendiz?->coursegroup ? 1 : 0,
            'totalAsignaciones' => $totalAsignaciones,
            'totalResultados' => $totalResultados,
            'progreso' => $progreso,
        ]);
    }

    public function ficha()
    {
        $aprendiz = auth()->user()?->apprentice;
        if (! $aprendiz) {
            return view('Usuarios.Aprendices.ficha', [
                'aprendiz' => null,
                'ficha' => null,
                'competencias' => collect(),
                'resumen' => ['asignaciones' => 0, 'asignaciones_activas' => 0, 'resultados' => 0, 'aprobados' => 0],
            ]);
        }

        $aprendiz->load([
            'coursegroup.program.area',
            'coursegroup.teacher.user',
            'coursegroup.teachers.user',
            'assignments.equipment.environment',
            'grades.result.competition',
        ]);

        $ficha = $aprendiz->coursegroup;
        $instructorIds = collect($ficha?->teacher_id)
            ->merge($ficha?->teachers->pluck('id') ?? collect())
            ->filter()
            ->unique()
            ->values();

        $competencias = $instructorIds->isEmpty()
            ? collect()
            : Competition::query()
                ->where(function ($consulta) use ($instructorIds) {
                    $consulta->whereIn('teacher_id', $instructorIds)
                        ->orWhereHas('teachers', fn ($teachers) => $teachers->whereIn('teachers.id', $instructorIds));
                })
                ->withCount('results')
                ->orderBy('nombre')
                ->get();

        $resumen = [
            'asignaciones' => $aprendiz->assignments->count(),
            'asignaciones_activas' => $aprendiz->assignments->where('Estado', 'Activo')->count(),
            'resultados' => $aprendiz->grades->count(),
            'aprobados' => $aprendiz->grades->where('estado_resultado', 'Aprobado')->count(),
        ];

        return view('Usuarios.Aprendices.ficha', compact('aprendiz', 'ficha', 'competencias', 'resumen'));
    }

    public function cronograma()
    {
        $aprendiz = auth()->user()?->apprentice;
        if (! $aprendiz) {
            return view('Usuarios.Aprendices.cronograma', [
                'aprendiz' => null,
                'ficha' => null,
                'eventos' => collect(),
                'proximos' => collect(),
                'resumen' => ['total' => 0, 'proximos' => 0, 'competencias' => 0, 'asignaciones' => 0],
            ]);
        }

        $aprendiz->load([
            'coursegroup.program',
            'coursegroup.teacher',
            'coursegroup.teachers',
            'assignments.equipment',
            'grades.result.competition',
        ]);

        $ficha = $aprendiz->coursegroup;
        $instructorIds = collect($ficha?->teacher_id)
            ->merge($ficha?->teachers->pluck('id') ?? collect())
            ->filter()
            ->unique()
            ->values();
        $competencias = $instructorIds->isEmpty()
            ? collect()
            : Competition::query()
                ->where(function ($consulta) use ($instructorIds) {
                    $consulta->whereIn('teacher_id', $instructorIds)
                        ->orWhereHas('teachers', fn ($teachers) => $teachers->whereIn('teachers.id', $instructorIds));
                })
                ->orderBy('fecha_inicio')
                ->get();

        $eventos = collect();

        if ($aprendiz->fecha_inicio) {
            $eventos->push([
                'fecha' => Carbon::parse($aprendiz->fecha_inicio),
                'titulo' => 'Inicio de mi formación',
                'descripcion' => $ficha?->codigo.' · '.($ficha?->program?->nombre ?? 'Programa no registrado'),
                'tipo' => 'Formación',
                'ruta' => route('aprendiz.ficha'),
            ]);
        }
        if ($aprendiz->fecha_fin) {
            $eventos->push([
                'fecha' => Carbon::parse($aprendiz->fecha_fin),
                'titulo' => 'Fecha programada de finalización',
                'descripcion' => $ficha?->codigo.' · '.($ficha?->program?->nombre ?? 'Programa no registrado'),
                'tipo' => 'Formación',
                'ruta' => route('aprendiz.ficha'),
            ]);
        }

        foreach ($competencias as $competencia) {
            if ($competencia->fecha_inicio) {
                $eventos->push([
                    'fecha' => Carbon::parse($competencia->fecha_inicio),
                    'titulo' => 'Inicio de competencia',
                    'descripcion' => $competencia->nombre,
                    'tipo' => 'Competencia',
                    'ruta' => route('aprendiz.resultados.index'),
                ]);
            }
            if ($competencia->fecha_fin) {
                $eventos->push([
                    'fecha' => Carbon::parse($competencia->fecha_fin),
                    'titulo' => 'Cierre de competencia',
                    'descripcion' => $competencia->nombre,
                    'tipo' => 'Competencia',
                    'ruta' => route('aprendiz.resultados.index'),
                ]);
            }
        }

        foreach ($aprendiz->assignments as $asignacion) {
            if (! $asignacion->fecha_asignacion) {
                continue;
            }

            $eventos->push([
                'fecha' => Carbon::parse($asignacion->fecha_asignacion),
                'titulo' => 'Asignación de '.($asignacion->equipment?->name ?? 'equipo'),
                'descripcion' => $asignacion->equipment?->environment?->nombre ?? 'Equipo disponible',
                'tipo' => 'Asignación',
                'ruta' => route('aprendiz.asignaciones.show', $asignacion),
            ]);
            if ($asignacion->fecha_devolucion) {
                $eventos->push([
                    'fecha' => Carbon::parse($asignacion->fecha_devolucion),
                    'titulo' => 'Devolución de '.($asignacion->equipment?->name ?? 'equipo'),
                    'descripcion' => $asignacion->equipment?->environment?->nombre ?? 'Equipo disponible',
                    'tipo' => 'Entrega',
                    'ruta' => route('aprendiz.asignaciones.show', $asignacion),
                ]);
            }
        }

        $eventos = $eventos->sortBy('fecha')->values();
        $proximos = $eventos->filter(fn (array $evento) => $evento['fecha']->isToday() || $evento['fecha']->isFuture());

        $resumen = [
            'total' => $eventos->count(),
            'proximos' => $proximos->count(),
            'competencias' => $competencias->count(),
            'asignaciones' => $aprendiz->assignments->count(),
        ];

        return view('Usuarios.Aprendices.cronograma', compact('aprendiz', 'ficha', 'eventos', 'proximos', 'resumen'));
    }

    public function perfil()
    {
        /** @var User $usuario */
        $usuario = auth()->user();

        return view('Usuarios.Aprendices.perfilAprendiz', [
            'usuario' => $usuario->load('apprentice.coursegroup.program'),
        ]);
    }

    public function edit()
    {
        /** @var User $usuario */
        $usuario = auth()->user();

        return view('Usuarios.Aprendices.editAprendiz', [
            'usuario' => $usuario->load('apprentice'),
            'fichas' => Course_group::with('program')->orderBy('codigo')->get(),
        ]);
    }

    public function update(PerfilAprendizRequest $request)
    {
        /** @var User $usuario */
        $usuario = auth()->user();
        $datos = $request->validated();

        if ($request->hasFile('foto_perfil')) {
            $datos['foto_perfil'] = $request->file('foto_perfil')->store('photos', 'public');
        }

        $usuario->update($datos);

        $usuario->apprentice()->updateOrCreate(['user_id' => $usuario->id], [
            'course_group_id' => $datos['course_group_id'],
            'estado' => $datos['estado'],
            'fecha_inicio' => $datos['fecha_inicio'],
            'fecha_fin' => $datos['fecha_fin'] ?? null,
        ]);

        return redirect()->route('aprendiz.perfil')->with('success', 'Perfil actualizado correctamente.');
    }
}
