<?php

namespace App\Dominios\Usuarios\Controllers;

use App\Dominios\Areas\Models\Area;
use App\Dominios\Asignaciones\Models\Assignment;
use App\Dominios\Competencias\Models\Competition;
use App\Dominios\Fichas\Models\Course_group;
use App\Dominios\Resultados\Models\Grade;
use App\Dominios\Usuarios\Models\Apprentice;
use App\Dominios\Usuarios\Models\Teacher;
use App\Dominios\Usuarios\Models\User;
use App\Dominios\Usuarios\Requests\PerfilInstructorRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function home()
    {
        /** @var User $usuario */
        $usuario = auth()->user();
        $instructor = $usuario->teacher;

        $fichas = $instructor
            ? Course_group::query()
                ->asignadasAlInstructor($instructor)
                ->with('program')
                ->withCount('apprentices')
                ->orderBy('codigo')
                ->get()
            : collect();

        $totalAprendices = $instructor
            ? $this->aprendicesAsignadosQuery($instructor)->count()
            : 0;
        $totalCompetencias = $instructor
            ? Competition::query()->asignadasAlInstructor($instructor)->count()
            : 0;
        $totalAsignaciones = $instructor
            ? $this->asignacionesVisiblesQuery($instructor)->count()
            : 0;
        $totalCalificaciones = $instructor
            ? Grade::query()
                ->whereIn('apprentice_id', $this->aprendicesAsignadosQuery($instructor)->select('apprentices.id'))
                ->count()
            : 0;
        $calificacionesEvaluadas = $instructor
            ? Grade::query()
                ->whereIn('apprentice_id', $this->aprendicesAsignadosQuery($instructor)->select('apprentices.id'))
                ->where('estado_resultado', '!=', 'Pendiente')
                ->count()
            : 0;
        $progreso = $totalCalificaciones > 0
            ? (int) round(($calificacionesEvaluadas / $totalCalificaciones) * 100)
            : 0;

        return view('Usuarios.Instructores.homeInstructor', [
            'nombre_1' => $usuario->nombre_1 ?? 'Instructor',
            'totalAprendices' => $totalAprendices,
            'fichas' => $fichas,
            'fichasAsignadas' => $fichas->count(),
            'totalCompetencias' => $totalCompetencias,
            'totalAsignaciones' => $totalAsignaciones,
            'progreso' => $progreso,
        ]);
    }

    public function aprendices(Request $request)
    {
        $estado = $request->string('estado')->toString();
        if (! in_array($estado, ['Activo', 'Retirado', 'Certificado'], true)) {
            $estado = '';
        }

        $instructor = $this->instructorActualOpcional();
        if (! $instructor) {
            return view('Usuarios.Instructores.aprendices', [
                'aprendices' => Apprentice::query()->whereRaw('1 = 0')->paginate(12),
                'resumen' => ['total' => 0, 'activos' => 0, 'certificados' => 0, 'asignaciones' => 0],
                'estado' => $estado,
            ]);
        }

        $fichaId = $request->integer('ficha');
        if ($fichaId) {
            $fichaAsignada = Course_group::query()
                ->asignadasAlInstructor($instructor)
                ->whereKey($fichaId)
                ->exists();
            abort_unless($fichaAsignada, 403);
        } else {
            $fichaId = null;
        }

        $aprendices = $this->aprendicesAsignadosQuery($instructor)
            ->with(['user', 'coursegroup.program'])
            ->withCount(['assignments', 'grades'])
            ->when($estado, fn ($consulta) => $consulta->where('estado', $estado))
            ->when($fichaId, fn ($consulta) => $consulta->where('course_group_id', $fichaId))
            ->when($request->filled('buscar'), function ($consulta) use ($request) {
                $buscar = trim((string) $request->input('buscar'));
                $consulta->whereHas('user', function ($usuarios) use ($buscar) {
                    $usuarios->where('nombre_1', 'like', "%{$buscar}%")
                        ->orWhere('nombre_2', 'like', "%{$buscar}%")
                        ->orWhere('apellido_1', 'like', "%{$buscar}%")
                        ->orWhere('apellido_2', 'like', "%{$buscar}%")
                        ->orWhere('identificacion', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('estado')
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        $base = $this->aprendicesAsignadosQuery($instructor)
            ->when($fichaId, fn ($consulta) => $consulta->where('course_group_id', $fichaId));
        $resumen = [
            'total' => (clone $base)->count(),
            'activos' => (clone $base)->where('estado', 'Activo')->count(),
            'certificados' => (clone $base)->where('estado', 'Certificado')->count(),
            'asignaciones' => Assignment::query()
                ->whereIn('apprentice_id', $base->select('apprentices.id'))
                ->count(),
        ];

        return view('Usuarios.Instructores.aprendices', compact('aprendices', 'resumen', 'estado'));
    }

    public function fichas()
    {
        $instructor = $this->instructorActualOpcional();
        if (! $instructor) {
            return view('Usuarios.Instructores.fichas', [
                'fichas' => Course_group::query()->whereRaw('1 = 0')->paginate(10),
                'resumen' => ['total' => 0, 'aprendices' => 0, 'capacidad' => 0, 'disponibles' => 0],
            ]);
        }

        $fichas = Course_group::query()
            ->asignadasAlInstructor($instructor)
            ->with(['program.area', 'teacher.user', 'teachers.user'])
            ->withCount('apprentices')
            ->orderBy('codigo')
            ->paginate(10);

        $resumen = [
            'total' => $fichas->total(),
            'aprendices' => $fichas->sum('apprentices_count'),
            'capacidad' => $fichas->sum('capacidad_aprendices'),
        ];
        $resumen['disponibles'] = max(0, $resumen['capacidad'] - $resumen['aprendices']);

        return view('Usuarios.Instructores.fichas', compact('fichas', 'resumen'));
    }

    public function fichaShow(Course_group $ficha)
    {
        $instructor = $this->instructorActual();
        abort_unless($ficha->estaAsignadaAlInstructor($instructor), 403);

        $ficha->load([
            'program.area',
            'teacher.user',
            'teachers.user',
            'apprentices.user',
            'apprentices.assignments',
        ]);

        $resumen = [
            'aprendices' => $ficha->apprentices->count(),
            'activos' => $ficha->apprentices->where('estado', 'Activo')->count(),
            'asignaciones' => $ficha->apprentices->sum(fn (Apprentice $aprendiz) => $aprendiz->assignments->count()),
            'instructores' => $ficha->teachers->pluck('id')->push($ficha->teacher_id)->filter()->unique()->count(),
        ];

        return view('Usuarios.Instructores.ficha', compact('ficha', 'resumen'));
    }

    public function actividades(Request $request)
    {
        $estado = $request->string('estado')->toString();
        if (! in_array($estado, ['Activo', 'Inactivo'], true)) {
            $estado = '';
        }

        $instructor = $this->instructorActualOpcional();
        if (! $instructor) {
            return view('Usuarios.Instructores.actividades', [
                'actividades' => Assignment::query()->whereRaw('1 = 0')->paginate(12),
                'resumen' => ['total' => 0, 'activas' => 0, 'finalizadas' => 0, 'aprendices' => 0],
                'estado' => $estado,
            ]);
        }

        $actividades = $this->asignacionesVisiblesQuery($instructor)
            ->with(['equipment.environment', 'apprentice.user', 'apprentice.coursegroup'])
            ->when($estado, fn ($consulta) => $consulta->where('Estado', $estado))
            ->when($request->filled('buscar'), function ($consulta) use ($request) {
                $buscar = trim((string) $request->input('buscar'));
                $consulta->where(function ($filtro) use ($buscar) {
                    $filtro->whereHas('equipment', function ($equipos) use ($buscar) {
                        $equipos->where('name', 'like', "%{$buscar}%")
                            ->orWhere('brand', 'like', "%{$buscar}%")
                            ->orWhere('equipment_type', 'like', "%{$buscar}%");
                    })->orWhereHas('apprentice.user', function ($usuarios) use ($buscar) {
                        $usuarios->where('nombre_1', 'like', "%{$buscar}%")
                            ->orWhere('apellido_1', 'like', "%{$buscar}%");
                    });
                });
            })
            ->latest('fecha_asignacion')
            ->paginate(12);
        $base = $this->asignacionesVisiblesQuery($instructor);
        $resumen = [
            'total' => (clone $base)->count(),
            'activas' => (clone $base)->where('Estado', 'Activo')->count(),
            'finalizadas' => (clone $base)->where('Estado', 'Inactivo')->count(),
            'aprendices' => $this->aprendicesAsignadosQuery($instructor)->count(),
        ];

        return view('Usuarios.Instructores.actividades', compact('actividades', 'resumen', 'estado'));
    }

    public function agenda()
    {
        $instructor = $this->instructorActualOpcional();
        if (! $instructor) {
            return view('Usuarios.Instructores.agenda', [
                'eventos' => collect(),
                'proximos' => collect(),
                'resumen' => ['total' => 0, 'proximos' => 0, 'fichas' => 0, 'competencias' => 0],
            ]);
        }

        $fichas = Course_group::query()
            ->asignadasAlInstructor($instructor)
            ->with(['program', 'apprentices'])
            ->get();
        $competencias = Competition::query()
            ->asignadasAlInstructor($instructor)
            ->orderBy('fecha_inicio')
            ->get();
        $asignaciones = $this->asignacionesVisiblesQuery($instructor)
            ->with(['equipment', 'apprentice.user'])
            ->get();

        $eventos = collect();

        foreach ($fichas as $ficha) {
            $inicio = $ficha->apprentices->map(fn (Apprentice $aprendiz) => $aprendiz->fecha_inicio)->filter()->min();
            $fin = $ficha->apprentices->map(fn (Apprentice $aprendiz) => $aprendiz->fecha_fin)->filter()->max();

            if ($inicio) {
                $eventos->push([
                    'fecha' => Carbon::parse($inicio),
                    'titulo' => 'Inicio de '.$ficha->codigo,
                    'descripcion' => $ficha->program?->nombre ?? 'Ficha de formación',
                    'tipo' => 'Inicio de ficha',
                    'ruta' => route('instructor.fichas.show', $ficha),
                ]);
            }
            if ($fin) {
                $eventos->push([
                    'fecha' => Carbon::parse($fin),
                    'titulo' => 'Finalización programada de '.$ficha->codigo,
                    'descripcion' => $ficha->program?->nombre ?? 'Ficha de formación',
                    'tipo' => 'Cierre de ficha',
                    'ruta' => route('instructor.fichas.show', $ficha),
                ]);
            }
        }

        foreach ($competencias as $competencia) {
            if ($competencia->fecha_inicio) {
                $eventos->push([
                    'fecha' => Carbon::parse($competencia->fecha_inicio),
                    'titulo' => 'Inicio de competencia',
                    'descripcion' => $competencia->nombre,
                    'tipo' => 'Competencia',
                    'ruta' => route('instructor.resultados.index'),
                ]);
            }
            if ($competencia->fecha_fin) {
                $eventos->push([
                    'fecha' => Carbon::parse($competencia->fecha_fin),
                    'titulo' => 'Cierre de competencia',
                    'descripcion' => $competencia->nombre,
                    'tipo' => 'Competencia',
                    'ruta' => route('instructor.resultados.index'),
                ]);
            }
        }

        foreach ($asignaciones as $asignacion) {
            if (! $asignacion->fecha_asignacion) {
                continue;
            }

            $eventos->push([
                'fecha' => Carbon::parse($asignacion->fecha_asignacion),
                'titulo' => 'Asignación de '.($asignacion->equipment?->name ?? 'equipo'),
                'descripcion' => $asignacion->apprentice?->user?->nombre_completo ?? 'Aprendiz',
                'tipo' => 'Actividad',
                'ruta' => route('instructor.asignaciones.show', $asignacion),
            ]);
            if ($asignacion->fecha_devolucion) {
                $eventos->push([
                    'fecha' => Carbon::parse($asignacion->fecha_devolucion),
                    'titulo' => 'Devolución de '.($asignacion->equipment?->name ?? 'equipo'),
                    'descripcion' => $asignacion->apprentice?->user?->nombre_completo ?? 'Aprendiz',
                    'tipo' => 'Entrega',
                    'ruta' => route('instructor.asignaciones.show', $asignacion),
                ]);
            }
        }

        $eventos = $eventos->sortBy('fecha')->values();
        $proximos = $eventos->filter(fn (array $evento) => $evento['fecha']->isToday() || $evento['fecha']->isFuture());

        $resumen = [
            'total' => $eventos->count(),
            'proximos' => $proximos->count(),
            'fichas' => $fichas->count(),
            'competencias' => $competencias->count(),
        ];

        return view('Usuarios.Instructores.agenda', compact('eventos', 'proximos', 'resumen'));
    }

    public function perfil()
    {
        /** @var User $usuario */
        $usuario = auth()->user();
        $usuario->load(['teacher.area', 'teacher.competencies']);

        return view('Usuarios.Instructores.perfilInstructor', compact('usuario'));
    }

    public function edit()
    {
        /** @var User $usuario */
        $usuario = User::findOrFail(auth()->id());
        $usuario->load('teacher');
        $areas = Area::orderBy('nombre')->get();
        $competencias = Competition::orderBy('nombre')->get();

        return view('Usuarios.Instructores.editInstructor', compact('usuario', 'areas', 'competencias'));
    }

    public function update(PerfilInstructorRequest $request)
    {
        /** @var User $usuario */
        $usuario = auth()->user();
        $datos = $request->validated();

        $usuario->update([
            'nombre_1' => $datos['nombre_1'],
            'nombre_2' => $datos['nombre_2'] ?? null,
            'apellido_1' => $datos['apellido_1'],
            'apellido_2' => $datos['apellido_2'] ?? null,
            'tipo_identificacion' => $datos['tipo_identificacion'],
            'identificacion' => $datos['identificacion'],
            'email' => $datos['email'],
        ]);

        if ($request->hasFile('foto_perfil')) {
            $usuario->update(['foto_perfil' => $request->file('foto_perfil')->store('photos', 'public')]);
        }

        $usuario->teacher()->updateOrCreate(['user_id' => $usuario->id], [
            'area_id' => $datos['area_id'],
            'especialidad' => $datos['especialidad'],
            'tipo_instructor' => $datos['tipo_instructor'],
            'fecha_inicio' => $datos['fecha_inicio'],
            'fecha_fin' => $datos['fecha_fin'] ?? null,
        ]);

        return redirect()->route('instructor.perfil')->with('success', 'Perfil actualizado correctamente.');
    }

    private function instructorActualOpcional(): ?Teacher
    {
        return auth()->user()?->teacher;
    }

    private function instructorActual(): Teacher
    {
        $instructor = $this->instructorActualOpcional();
        abort_unless($instructor, 403, 'Debes completar tu perfil de instructor para continuar.');

        return $instructor;
    }

    private function aprendicesAsignadosQuery(Teacher $instructor)
    {
        return Apprentice::query()->whereHas('coursegroup', function ($coursegroups) use ($instructor) {
            $coursegroups->asignadasAlInstructor($instructor);
        });
    }

    private function asignacionesVisiblesQuery(Teacher $instructor)
    {
        return Assignment::query()->whereHas('apprentice.coursegroup', function ($coursegroups) use ($instructor) {
            $coursegroups->asignadasAlInstructor($instructor);
        });
    }
}
