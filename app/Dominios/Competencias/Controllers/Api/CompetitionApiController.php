<?php

namespace App\Dominios\Competencias\Controllers\Api;

use App\Dominios\Competencias\Models\Competition;
use App\Dominios\Competencias\Requests\CompetitionRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompetitionApiController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Competition::query()
            ->with(['teacher.user', 'teachers.user'])
            ->withCount('results')
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = trim((string) $request->input('buscar'));
                $query->where(function ($competencias) use ($buscar) {
                    $competencias->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('codigo', 'like', "%{$buscar}%");
                });
            })
            ->when($request->filled('teacher_id'), fn ($query) => $query->where('teacher_id', $request->integer('teacher_id')))
            ->orderByDesc('id');

        return $this->paginated($this->applyPagination($query, $request), 'Competencias obtenidas correctamente.');
    }

    public function store(CompetitionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $competencia = Competition::create($data);
        $competencia->teachers()->sync($this->teacherIds($request, $data));

        return $this->created($this->loadRelations($competencia), 'Competencia creada correctamente.');
    }

    public function show(Competition $competencia): JsonResponse
    {
        return $this->success($this->loadRelations($competencia), 'Competencia obtenida correctamente.');
    }

    public function update(CompetitionRequest $request, Competition $competencia): JsonResponse
    {
        $data = $request->validated();
        $competencia->update($data);
        $competencia->teachers()->sync($this->teacherIds($request, $data));

        return $this->success($this->loadRelations($competencia), 'Competencia actualizada correctamente.');
    }

    public function destroy(Competition $competencia): JsonResponse
    {
        $competencia->delete();

        return $this->success(null, 'Competencia eliminada correctamente.');
    }

    private function teacherIds(Request $request, array $data): array
    {
        $ids = $request->input('teacher_ids', $data['teacher_id'] ? [$data['teacher_id']] : []);
        $ids = array_values(array_unique(array_filter((array) $ids)));

        Validator::make(['teacher_ids' => $ids], [
            'teacher_ids' => ['array'],
            'teacher_ids.*' => ['integer', 'exists:teachers,id'],
        ])->validate();

        return $ids;
    }

    private function loadRelations(Competition $competencia): Competition
    {
        return $competencia->load(['teacher.user', 'teachers.user', 'results'])->loadCount('results');
    }
}
