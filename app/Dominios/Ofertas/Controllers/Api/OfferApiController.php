<?php

namespace App\Dominios\Ofertas\Controllers\Api;

use App\Dominios\Ofertas\Models\Offer;
use App\Dominios\Ofertas\Requests\OfferRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OfferApiController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $user = $this->requireRole(['Admin', 'Instructor', 'Aprendiz', 'Aspirante']);
        $query = Offer::query()
            ->with('program.area.trainingcenter')
            ->withCount(['inscriptions as inscripciones_activas_count' => function ($registros) {
                $registros->where('estado', '!=', 'Cancelada');
            }]);

        if ($user->rol !== 'Admin') {
            $query->where('publicada', true);
        }

        $query->when($request->filled('buscar'), function ($builder) use ($request) {
            $buscar = trim((string) $request->input('buscar'));
            $builder->whereHas('program', function ($programas) use ($buscar) {
                $programas->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('codigo_programa', 'like', "%{$buscar}%")
                    ->orWhereHas('area', function ($areas) use ($buscar) {
                        $areas->where('nombre', 'like', "%{$buscar}%");
                    });
            });
        })->when($request->boolean('solo_abiertas'), function ($builder) {
            $builder->where('publicada', true)
                ->where(function ($ofertas) {
                    $ofertas->whereNull('fecha_fin_convocatoria')
                        ->orWhereDate('fecha_fin_convocatoria', '>=', now()->toDateString());
                });
        })->latest('id');

        return $this->paginated($this->applyPagination($query, $request), 'Ofertas obtenidas correctamente.');
    }

    public function store(OfferRequest $request): JsonResponse
    {
        $user = $this->requireAdmin();
        $data = $request->validated();
        $data['admin_id'] = $this->adminId($user);
        $data['imagen'] = $request->file('imagen')?->store('offers', 'public');

        $oferta = Offer::create($data);

        return $this->created($this->loadRelations($oferta), 'Oferta creada correctamente.');
    }

    public function show(Offer $oferta): JsonResponse
    {
        $this->authorizeVisibility($oferta);

        return $this->success($this->loadRelations($oferta), 'Oferta obtenida correctamente.');
    }

    public function update(OfferRequest $request, Offer $oferta): JsonResponse
    {
        $this->requireAdmin();
        $data = $request->validated();
        $data['admin_id'] = $this->adminId($this->currentUser());
        $data['imagen'] = $request->file('imagen')?->store('offers', 'public') ?? $oferta->imagen;
        $oferta->update($data);

        return $this->success($this->loadRelations($oferta->fresh()), 'Oferta actualizada correctamente.');
    }

    public function destroy(Offer $oferta): JsonResponse
    {
        $this->requireAdmin();
        $oferta->delete();

        return $this->success(null, 'Oferta eliminada correctamente.');
    }

    private function authorizeVisibility(Offer $oferta): void
    {
        $user = $this->requireRole(['Admin', 'Instructor', 'Aprendiz', 'Aspirante']);
        abort_if($user->rol !== 'Admin' && ! $oferta->publicada, 404, 'La oferta no está disponible.');
    }

    private function adminId($user): int
    {
        $adminId = $user->admin?->id;
        abort_unless($adminId, 403, 'El usuario administrador no tiene un perfil de administrador asociado.');

        return $adminId;
    }

    private function loadRelations(Offer $oferta): Offer
    {
        return $oferta->load(['program.area.trainingcenter', 'admin.user'])
            ->loadCount(['inscriptions as inscripciones_activas_count' => function ($registros) {
                $registros->where('estado', '!=', 'Cancelada');
            }]);
    }
}
