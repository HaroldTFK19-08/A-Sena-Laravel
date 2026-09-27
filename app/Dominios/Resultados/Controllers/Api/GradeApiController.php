<?php

namespace App\Dominios\Resultados\Controllers\Api;

use App\Dominios\Resultados\Models\Grade;
use App\Dominios\Resultados\Models\Result;
use App\Dominios\Resultados\Requests\GradeApiRequest;
use App\Dominios\Usuarios\Models\Apprentice;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GradeApiController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $user = $this->requireRole(['Admin', 'Instructor', 'Aprendiz']);
        $query = Grade::query()->with(['result.competition', 'apprentice.user', 'teacher.user']);

        if ($user?->rol === 'Instructor') {
            $teacher = $user->teacher;
            $query->whereHas('apprentice.coursegroup', function ($fichas) use ($teacher) {
                if ($teacher) {
                    $fichas->asignadasAlInstructor($teacher);
                } else {
                    $fichas->whereRaw('1 = 0');
                }
            });
        } elseif ($user?->rol === 'Aprendiz') {
            $query->whereHas('apprentice', function ($aprendices) use ($user) {
                $aprendices->where('user_id', $user->id);
            });
        }

        $query->when($request->filled('estado_resultado'), fn ($builder) => $builder->where('estado_resultado', $request->input('estado_resultado')))
            ->when($request->filled('result_id'), fn ($builder) => $builder->where('result_id', $request->integer('result_id')))
            ->when($request->filled('apprentice_id'), fn ($builder) => $builder->where('apprentice_id', $request->integer('apprentice_id')))
            ->orderByDesc('id');

        return $this->paginated($this->applyPagination($query, $request), 'Calificaciones obtenidas correctamente.');
    }

    public function store(GradeApiRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->authorizeAcademicData($data);

        $grade = Grade::updateOrCreate(
            [
                'result_id' => $data['result_id'],
                'apprentice_id' => $data['apprentice_id'],
            ],
            [
                'teacher_id' => $this->teacherId($data['teacher_id'] ?? null),
                'estado_resultado' => $data['estado_resultado'],
                'comentarios' => $data['comentarios'] ?? null,
            ]
        );

        return $this->created($this->loadRelations($grade), 'Calificación registrada correctamente.');
    }

    public function show(Grade $calificacion): JsonResponse
    {
        $this->authorizeGrade($calificacion);

        return $this->success($this->loadRelations($calificacion), 'Calificación obtenida correctamente.');
    }

    public function update(GradeApiRequest $request, Grade $calificacion): JsonResponse
    {
        $this->authorizeGrade($calificacion);
        $data = $request->validated();
        $this->authorizeAcademicData($data);

        $calificacion->update([
            'result_id' => $data['result_id'],
            'apprentice_id' => $data['apprentice_id'],
            'teacher_id' => $this->teacherId($data['teacher_id'] ?? null),
            'estado_resultado' => $data['estado_resultado'],
            'comentarios' => $data['comentarios'] ?? null,
        ]);

        return $this->success($this->loadRelations($calificacion), 'Calificación actualizada correctamente.');
    }

    public function destroy(Grade $calificacion): JsonResponse
    {
        $this->authorizeGrade($calificacion);
        $calificacion->delete();

        return $this->success(null, 'Calificación eliminada correctamente.');
    }

    private function authorizeAcademicData(array $data): void
    {
        $user = $this->currentUser();

        if (! $user || $user->rol === 'Admin') {
            return;
        }

        $teacher = $user->teacher;
        $apprentice = Apprentice::with('coursegroup')->find($data['apprentice_id']);
        $result = Result::with('competition')->find($data['result_id']);

        abort_unless(
            $teacher
            && $apprentice?->coursegroup?->estaAsignadaAlInstructor($teacher)
            && $result?->competition?->estaAsignadaAlInstructor($teacher),
            403,
            'El aprendiz o el resultado no pertenece a tu ámbito académico.'
        );
    }

    private function authorizeGrade(Grade $calificacion): void
    {
        $user = $this->currentUser();

        if (! $user || $user->rol === 'Admin') {
            return;
        }

        $teacher = $user->teacher;
        abort_unless(
            $teacher && $calificacion->apprentice?->coursegroup?->estaAsignadaAlInstructor($teacher),
            403,
            'No tienes acceso a esta calificación.'
        );
    }

    private function teacherId(?int $requestedTeacherId = null): ?int
    {
        $user = $this->currentUser();

        if ($user?->rol === 'Instructor') {
            return $user->teacher?->id;
        }

        return $requestedTeacherId;
    }

    private function loadRelations(Grade $grade): Grade
    {
        return $grade->load(['result.competition', 'apprentice.user', 'apprentice.coursegroup', 'teacher.user']);
    }
}
