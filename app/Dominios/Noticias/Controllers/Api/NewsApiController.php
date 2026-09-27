<?php

namespace App\Dominios\Noticias\Controllers\Api;

use App\Dominios\Noticias\Models\News;
use App\Dominios\Noticias\Requests\NewsApiRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsApiController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $query = News::query()
            ->with(['trainingcenter', 'admin.user'])
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = trim((string) $request->input('buscar'));
                $query->where(function ($noticias) use ($buscar) {
                    $noticias->where('titulo', 'like', "%{$buscar}%")
                        ->orWhere('descripcion', 'like', "%{$buscar}%");
                });
            })
            ->when($request->filled('categoria'), fn ($query) => $query->where('categoria', $request->input('categoria')))
            ->when($request->filled('estado'), fn ($query) => $query->where('estado', $request->input('estado')))
            ->when($request->has('publicada'), fn ($query) => $query->where('publicada', $request->boolean('publicada')))
            ->latest('id');

        return $this->paginated($this->applyPagination($query, $request), 'Noticias obtenidas correctamente.');
    }

    public function store(NewsApiRequest $request): JsonResponse
    {
        $user = $this->requireAdmin();
        $data = $request->validated();
        $data['admin_id'] = $this->adminId($user);
        $data['imagen'] = $request->file('imagen')?->store('news', 'public');

        $noticia = News::create($data);

        return $this->created($this->loadRelations($noticia), 'Noticia creada correctamente.');
    }

    public function show(News $noticia): JsonResponse
    {
        $this->requireAdmin();

        return $this->success($this->loadRelations($noticia), 'Noticia obtenida correctamente.');
    }

    public function update(NewsApiRequest $request, News $noticia): JsonResponse
    {
        $user = $this->requireAdmin();
        $data = $request->validated();
        $data['admin_id'] = $this->adminId($user);
        $data['imagen'] = $request->file('imagen')?->store('news', 'public') ?? $noticia->imagen;
        $noticia->update($data);

        return $this->success($this->loadRelations($noticia->fresh()), 'Noticia actualizada correctamente.');
    }

    public function destroy(News $noticia): JsonResponse
    {
        $this->requireAdmin();
        $noticia->delete();

        return $this->success(null, 'Noticia eliminada correctamente.');
    }

    private function adminId($user): int
    {
        $adminId = $user->admin?->id;
        abort_unless($adminId, 403, 'El usuario administrador no tiene un perfil de administrador asociado.');

        return $adminId;
    }

    private function loadRelations(News $noticia): News
    {
        return $noticia->load(['trainingcenter', 'admin.user']);
    }
}
