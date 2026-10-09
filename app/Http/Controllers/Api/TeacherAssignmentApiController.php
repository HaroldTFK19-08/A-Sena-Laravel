<?php

namespace App\Http\Controllers\Api;

use App\Dominios\Competencias\Models\CompetitionTeacher;
use App\Dominios\Fichas\Models\CourseGroupTeacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeacherAssignmentApiController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $config = $this->config($request);
        $query = $config['model']::query()->with($config['relations']);

        foreach ($config['fields'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->input($field));
            }
        }

        return $this->paginated(
            $this->applyPagination($query->orderByDesc('id'), $request),
            "{$config['label']} obtenidas correctamente."
        );
    }

    public function store(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $config = $this->config($request);
        $data = $request->validate($this->rules($config));
        $assignment = $config['model']::firstOrCreate($data);

        return $this->created($assignment->load($config['relations']), "{$config['singular']} asignado correctamente.");
    }

    public function show(Request $request, int $assignmentId): JsonResponse
    {
        $this->requireAdmin();
        $config = $this->config($request);

        return $this->success(
            $config['model']::with($config['relations'])->findOrFail($assignmentId),
            "{$config['singular']} obtenido correctamente."
        );
    }

    public function update(Request $request, int $assignmentId): JsonResponse
    {
        $this->requireAdmin();
        $config = $this->config($request);
        $assignment = $config['model']::findOrFail($assignmentId);
        $assignment->update($request->validate($this->rules($config)));

        return $this->success($assignment->fresh($config['relations']), "{$config['singular']} actualizado correctamente.");
    }

    public function destroy(Request $request, int $assignmentId): JsonResponse
    {
        $this->requireAdmin();
        $config = $this->config($request);
        $config['model']::findOrFail($assignmentId)->delete();

        return $this->success(null, "{$config['singular']} eliminado correctamente.");
    }

    private function config(Request $request): array
    {
        return match ($request->route('assignmentType')) {
            'competencias-instructores' => [
                'model' => CompetitionTeacher::class,
                'label' => 'Asignaciones de competencias',
                'singular' => 'Instructor de competencia',
                'fields' => ['competency_id', 'teacher_id'],
                'relations' => ['competition', 'teacher.user'],
                'rules' => [
                    'competency_id' => ['required', 'integer', 'exists:competitions,id'],
                    'teacher_id' => ['required', 'integer', 'exists:teachers,id'],
                ],
            ],
            'fichas-instructores' => [
                'model' => CourseGroupTeacher::class,
                'label' => 'Asignaciones de fichas',
                'singular' => 'Instructor de ficha',
                'fields' => ['course_group_id', 'teacher_id'],
                'relations' => ['courseGroup', 'teacher.user'],
                'rules' => [
                    'course_group_id' => ['required', 'integer', 'exists:course_groups,id'],
                    'teacher_id' => ['required', 'integer', 'exists:teachers,id'],
                ],
            ],
            default => abort(404),
        };
    }

    private function rules(array $config): array
    {
        return array_intersect_key($config['rules'], array_flip($config['fields']));
    }
}
