<?php

namespace App\Dominios\Fichas\Controllers\Api;

use App\Dominios\Fichas\Models\Course_group;
use App\Dominios\Fichas\Requests\CourseGroupRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseGroupApiController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Course_group::query()
            ->with(['program.area.trainingcenter', 'teacher.user', 'teachers.user'])
            ->withCount('apprentices')
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = trim((string) $request->input('buscar'));
                $query->where(function ($fichas) use ($buscar) {
                    $fichas->where('codigo', 'like', "%{$buscar}%")
                        ->orWhereHas('program', function ($programas) use ($buscar) {
                            $programas->where('nombre', 'like', "%{$buscar}%")
                                ->orWhere('codigo_programa', 'like', "%{$buscar}%");
                        });
                });
            })
            ->orderByDesc('id');

        return $this->paginated($this->applyPagination($query, $request), 'Fichas obtenidas correctamente.');
    }

    public function store(CourseGroupRequest $request): JsonResponse
    {
        $data = $request->validated();
        $ficha = Course_group::create($data);
        $ficha->teachers()->sync($this->teacherIds($request, $data));

        return $this->created($this->loadRelations($ficha), 'Ficha creada correctamente.');
    }

    public function show(Course_group $ficha): JsonResponse
    {
        return $this->success($this->loadRelations($ficha), 'Ficha obtenida correctamente.');
    }

    public function update(CourseGroupRequest $request, Course_group $ficha): JsonResponse
    {
        $data = $request->validated();
        $ficha->update($data);
        $ficha->teachers()->sync($this->teacherIds($request, $data));

        return $this->success($this->loadRelations($ficha), 'Ficha actualizada correctamente.');
    }

    public function destroy(Course_group $ficha): JsonResponse
    {
        $ficha->delete();

        return $this->success(null, 'Ficha eliminada correctamente.');
    }

    private function teacherIds(Request $request, array $data): array
    {
        $ids = $request->input('teacher_ids', [$data['teacher_id']]);
        $ids = array_values(array_unique(array_filter((array) $ids)));

        Validator::make(['teacher_ids' => $ids], [
            'teacher_ids' => ['array'],
            'teacher_ids.*' => ['integer', 'exists:teachers,id'],
        ])->validate();

        return $ids;
    }

    private function loadRelations(Course_group $ficha): Course_group
    {
        return $ficha->load(['program.area.trainingcenter', 'teacher.user', 'teachers.user', 'apprentices.user'])->loadCount('apprentices');
    }
}
