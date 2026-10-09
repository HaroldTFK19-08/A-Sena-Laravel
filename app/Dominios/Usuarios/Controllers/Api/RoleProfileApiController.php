<?php

namespace App\Dominios\Usuarios\Controllers\Api;

use App\Dominios\Usuarios\Models\Admin;
use App\Dominios\Usuarios\Models\Apprentice;
use App\Dominios\Usuarios\Models\Aspirant;
use App\Dominios\Usuarios\Models\Teacher;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleProfileApiController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $user = $this->requireRole(['Admin', 'Instructor']);
        $config = $this->profileConfig($request);
        $query = $config['model']::query()->with($config['relations']);

        if ($user?->rol === 'Instructor') {
            abort_unless($request->route('profileType') === 'aprendices', 403);
            $teacher = $user->teacher;
            $query->whereHas('coursegroup', function (Builder $fichas) use ($teacher) {
                if ($teacher) {
                    $fichas->asignadasAlInstructor($teacher);
                } else {
                    $fichas->whereRaw('1 = 0');
                }
            });
        }

        if ($request->filled('buscar')) {
            $buscar = trim((string) $request->input('buscar'));
            $query->whereHas('user', function (Builder $users) use ($buscar) {
                $users->where('nombre_1', 'like', "%{$buscar}%")
                    ->orWhere('apellido_1', 'like', "%{$buscar}%")
                    ->orWhere('identificacion', 'like', "%{$buscar}%")
                    ->orWhere('email', 'like', "%{$buscar}%");
            });
        }

        return $this->paginated(
            $this->applyPagination($query->orderByDesc('id'), $request),
            "{$config['label']} obtenidos correctamente."
        );
    }

    public function store(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $config = $this->profileConfig($request);
        $data = $request->validate($this->rules($config));
        $data = $this->storeFiles($request, $data, $config);
        $profile = $config['model']::create($data);

        return $this->created(
            $profile->load($config['relations']),
            "{$config['label_singular']} creado correctamente."
        );
    }

    public function show(Request $request, int $profileId): JsonResponse
    {
        $this->requireAdmin();
        $config = $this->profileConfig($request);

        return $this->success(
            $config['model']::with($config['relations'])->findOrFail($profileId),
            "{$config['label_singular']} obtenido correctamente."
        );
    }

    public function update(Request $request, int $profileId): JsonResponse
    {
        $this->requireAdmin();
        $config = $this->profileConfig($request);
        $profile = $config['model']::findOrFail($profileId);
        $data = $request->validate($this->rules($config, $profileId));
        $data = $this->storeFiles($request, $data, $config, $profile);
        $profile->update($data);

        return $this->success(
            $profile->fresh($config['relations']),
            "{$config['label_singular']} actualizado correctamente."
        );
    }

    public function destroy(Request $request, int $profileId): JsonResponse
    {
        $this->requireAdmin();
        $config = $this->profileConfig($request);
        $config['model']::findOrFail($profileId)->delete();

        return $this->success(null, "{$config['label_singular']} eliminado correctamente.");
    }

    private function profileConfig(Request $request): array
    {
        return match ($request->route('profileType')) {
            'admins' => [
                'model' => Admin::class,
                'table' => 'admins',
                'role' => 'Admin',
                'label' => 'Administradores',
                'label_singular' => 'Administrador',
                'relations' => ['user'],
                'rules' => [
                    'cargo' => ['required', 'string', 'max:255'],
                    'ubicacion_oficina' => ['required', 'string', 'max:255'],
                    'direccion' => ['nullable', 'string', 'max:255'],
                ],
            ],
            'instructores' => [
                'model' => Teacher::class,
                'table' => 'teachers',
                'role' => 'Instructor',
                'label' => 'Instructores',
                'label_singular' => 'Instructor',
                'relations' => ['user', 'area'],
                'rules' => [
                    'area_id' => ['required', 'integer', 'exists:areas,id'],
                    'especialidad' => ['required', 'string', 'max:150'],
                    'tipo_instructor' => ['required', Rule::in(['Planta', 'Contratista'])],
                    'fecha_inicio' => ['required', 'date'],
                    'fecha_fin' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
                ],
            ],
            'aprendices' => [
                'model' => Apprentice::class,
                'table' => 'apprentices',
                'role' => 'Aprendiz',
                'label' => 'Aprendices',
                'label_singular' => 'Aprendiz',
                'relations' => ['user', 'coursegroup.program'],
                'rules' => [
                    'course_group_id' => ['required', 'integer', 'exists:course_groups,id'],
                    'estado' => ['required', Rule::in(['Activo', 'Retirado', 'Certificado'])],
                    'fecha_inicio' => ['required', 'date'],
                    'fecha_fin' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
                ],
            ],
            'aspirantes' => [
                'model' => Aspirant::class,
                'table' => 'aspirants',
                'role' => 'Aspirante',
                'label' => 'Aspirantes',
                'label_singular' => 'Aspirante',
                'relations' => ['user'],
                'rules' => [
                    'eps' => ['required', Rule::in(['SURA', 'Sanitas', 'Nueva EPS', 'Salud Total', 'Compensar', 'Coosalud', 'Emssanar'])],
                    'certificado_eps' => ['nullable', 'file', 'mimes:pdf,png,jpg,jpeg', 'max:4096'],
                    'certificado_bachiller' => ['nullable', 'file', 'mimes:pdf,png,jpg,jpeg', 'max:4096'],
                    'certificado_icfes' => ['nullable', 'file', 'mimes:pdf,png,jpg,jpeg', 'max:4096'],
                ],
            ],
            default => abort(404),
        };
    }

    private function rules(array $config, ?int $profileId = null): array
    {
        return [
            'user_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where('rol', $config['role']),
                Rule::unique($config['table'], 'user_id')->ignore($profileId),
            ],
            ...$config['rules'],
        ];
    }

    private function storeFiles(Request $request, array $data, array $config, ?Model $profile = null): array
    {
        foreach ($config['rules'] as $field => $_) {
            if (! $request->hasFile($field)) {
                continue;
            }

            $data[$field] = $request->file($field)->store("certificates/{$config['table']}", 'public');
        }

        if ($profile && $config['table'] === 'aspirants') {
            foreach (['certificado_eps', 'certificado_bachiller', 'certificado_icfes'] as $field) {
                if (! $request->hasFile($field)) {
                    unset($data[$field]);
                }
            }
        }

        return $data;
    }
}
