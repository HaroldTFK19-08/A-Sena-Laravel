<?php

namespace App\Dominios\Asignaciones\Controllers\Api;

use App\Dominios\Asignaciones\Models\Assignment;
use App\Dominios\Asignaciones\Requests\AssignmentRequest;
use App\Dominios\Usuarios\Models\Apprentice;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssignmentApiController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $user = $this->requireRole(['Admin', 'Instructor', 'Aprendiz']);
        $query = Assignment::query()->with(['equipment.environment', 'apprentice.user', 'apprentice.coursegroup']);

        $this->scopeQuery($query, $user);

        $query->when($request->filled('estado'), fn ($builder) => $builder->where('Estado', $request->input('estado')))
            ->when($request->filled('equipment_id'), fn ($builder) => $builder->where('equipment_id', $request->integer('equipment_id')))
            ->when($request->filled('apprentice_id'), fn ($builder) => $builder->where('apprentice_id', $request->integer('apprentice_id')))
            ->when($request->filled('buscar'), function ($builder) use ($request) {
                $buscar = trim((string) $request->input('buscar'));
                $builder->where(function ($asignaciones) use ($buscar) {
                    $asignaciones->whereHas('equipment', function ($equipos) use ($buscar) {
                        $equipos->where('name', 'like', "%{$buscar}%")
                            ->orWhere('brand', 'like', "%{$buscar}%")
                            ->orWhere('equipment_type', 'like', "%{$buscar}%");
                    })->orWhereHas('apprentice.user', function ($usuarios) use ($buscar) {
                        $usuarios->where('nombre_1', 'like', "%{$buscar}%")
                            ->orWhere('apellido_1', 'like', "%{$buscar}%");
                    });
                });
            })
            ->latest('id');

        return $this->paginated($this->applyPagination($query, $request), 'Asignaciones obtenidas correctamente.');
    }

    public function store(AssignmentRequest $request): JsonResponse
    {
        $user = $this->requireRole(['Admin', 'Instructor']);
        $data = $request->validated();
        $this->authorizeApprentice($user, Apprentice::findOrFail($data['apprentice_id']));

        $asignacion = Assignment::create($data);

        return $this->created($this->loadRelations($asignacion), 'Asignación creada correctamente.');
    }

    public function show(Assignment $asignacion): JsonResponse
    {
        $this->authorizeAssignment($asignacion);

        return $this->success($this->loadRelations($asignacion), 'Asignación obtenida correctamente.');
    }

    public function update(AssignmentRequest $request, Assignment $asignacion): JsonResponse
    {
        $user = $this->requireRole(['Admin', 'Instructor']);
        $this->authorizeAssignment($asignacion);
        $this->authorizeApprentice($user, Apprentice::findOrFail($request->integer('apprentice_id')));
        $asignacion->update($request->validated());

        return $this->success($this->loadRelations($asignacion->fresh()), 'Asignación actualizada correctamente.');
    }

    public function destroy(Assignment $asignacion): JsonResponse
    {
        $this->authorizeAssignment($asignacion);
        $asignacion->delete();

        return $this->success(null, 'Asignación eliminada correctamente.');
    }

    private function scopeQuery($query, $user): void
    {
        if ($user->rol === 'Aprendiz') {
            $query->whereHas('apprentice', function ($aprendices) use ($user) {
                $aprendices->where('user_id', $user->id);
            });

            return;
        }

        if ($user->rol === 'Instructor') {
            $teacher = $user->teacher;
            $query->whereHas('apprentice.coursegroup', function ($fichas) use ($teacher) {
                if ($teacher) {
                    $fichas->asignadasAlInstructor($teacher);
                } else {
                    $fichas->whereRaw('1 = 0');
                }
            });
        }
    }

    private function authorizeApprentice($user, Apprentice $apprentice): void
    {
        if ($user->rol === 'Admin') {
            return;
        }

        $teacher = $user->teacher;
        abort_unless(
            $teacher && $apprentice->coursegroup?->estaAsignadaAlInstructor($teacher),
            403,
            'El aprendiz no pertenece a tu ámbito de fichas.'
        );
    }

    private function authorizeAssignment(Assignment $asignacion): void
    {
        $user = $this->requireRole(['Admin', 'Instructor', 'Aprendiz']);
        $asignacion->loadMissing('apprentice.coursegroup');

        if ($user->rol === 'Aprendiz') {
            abort_unless($asignacion->apprentice?->user_id === $user->id, 403, 'No tienes acceso a esta asignación.');

            return;
        }

        if ($user->rol === 'Instructor') {
            $teacher = $user->teacher;
            abort_unless($teacher && $asignacion->apprentice?->coursegroup?->estaAsignadaAlInstructor($teacher), 403, 'No tienes acceso a esta asignación.');
        }
    }

    private function loadRelations(Assignment $asignacion): Assignment
    {
        return $asignacion->load(['equipment.environment', 'apprentice.user', 'apprentice.coursegroup.program']);
    }
}
