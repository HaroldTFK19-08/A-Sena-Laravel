<?php

namespace App\Dominios\Inscripciones\Controllers\Api;

use App\Dominios\Inscripciones\Models\Registration;
use App\Dominios\Inscripciones\Requests\RegistrationApiRequest;
use App\Dominios\Ofertas\Models\Offer;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistrationApiController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $user = $this->requireRole(['Admin', 'Aspirante']);
        $query = Registration::query()->with(['offer.program', 'aspirant.user']);

        if ($user->rol === 'Aspirante') {
            $query->whereHas('aspirant', function ($aspirantes) use ($user) {
                $aspirantes->where('user_id', $user->id);
            });
        }

        $query->when($request->filled('estado'), fn ($builder) => $builder->where('estado', $request->input('estado')))
            ->when($request->filled('offer_id'), fn ($builder) => $builder->where('offer_id', $request->integer('offer_id')))
            ->latest('id');

        return $this->paginated($this->applyPagination($query, $request), 'Inscripciones obtenidas correctamente.');
    }

    public function store(RegistrationApiRequest $request): JsonResponse
    {
        $user = $this->requireRole(['Admin', 'Aspirante']);
        $data = $request->validated();

        if ($user->rol === 'Aspirante') {
            $aspirant = $user->aspirant;
            abort_unless($aspirant, 403, 'Debes tener un perfil de aspirante para inscribirte.');
            $this->assertOfferOpen(Offer::findOrFail($data['offer_id']));
            $this->assertUnique($aspirant->id, $data['offer_id']);

            $registro = Registration::create([
                'aspirant_id' => $aspirant->id,
                'offer_id' => $data['offer_id'],
                'estado' => 'Registrado',
                'Fecha_inscripcion' => $data['Fecha_inscripcion'] ?? now(),
            ]);
        } else {
            $this->assertUnique($data['aspirant_id'], $data['offer_id']);
            $registro = Registration::create([
                ...$data,
                'Fecha_inscripcion' => $data['Fecha_inscripcion'] ?? now(),
            ]);
        }

        return $this->created($this->loadRelations($registro), 'Inscripción creada correctamente.');
    }

    public function show(Registration $inscripcion): JsonResponse
    {
        $this->authorizeRegistration($inscripcion);

        return $this->success($this->loadRelations($inscripcion), 'Inscripción obtenida correctamente.');
    }

    public function update(RegistrationApiRequest $request, Registration $inscripcion): JsonResponse
    {
        $user = $this->requireRole(['Admin', 'Aspirante']);
        $this->authorizeRegistration($inscripcion);
        $data = $request->validated();

        if ($user->rol === 'Aspirante') {
            abort_unless($inscripcion->permiteEdicion(), 403, 'La inscripción ya no permite modificaciones.');
            $this->assertOfferOpen(Offer::findOrFail($data['offer_id']));
            $this->assertUnique($inscripcion->aspirant_id, $data['offer_id'], $inscripcion->id);
            $inscripcion->update(['offer_id' => $data['offer_id']]);
        } else {
            $this->assertUnique($data['aspirant_id'], $data['offer_id'], $inscripcion->id);
            $inscripcion->update($data);
        }

        return $this->success($this->loadRelations($inscripcion->fresh()), 'Inscripción actualizada correctamente.');
    }

    public function destroy(Registration $inscripcion): JsonResponse
    {
        $user = $this->requireRole(['Admin', 'Aspirante']);
        $this->authorizeRegistration($inscripcion);

        if ($user->rol === 'Aspirante') {
            abort_unless($inscripcion->permiteCancelacion(), 403, 'La inscripción no puede cancelarse.');
            $inscripcion->update(['estado' => 'Cancelada']);
        } else {
            $inscripcion->delete();
        }

        return $this->success(null, $user->rol === 'Aspirante' ? 'Inscripción cancelada correctamente.' : 'Inscripción eliminada correctamente.');
    }

    private function authorizeRegistration(Registration $inscripcion): void
    {
        $user = $this->requireRole(['Admin', 'Aspirante']);
        if ($user->rol === 'Admin') {
            return;
        }

        $inscripcion->loadMissing('aspirant');
        abort_unless($inscripcion->aspirant?->user_id === $user->id, 403, 'No tienes acceso a esta inscripción.');
    }

    private function assertOfferOpen(Offer $oferta): void
    {
        abort_unless($oferta->publicada && $oferta->estaAbierta(), 422, 'La oferta no admite nuevas inscripciones.');
    }

    private function assertUnique(int $aspirantId, int $offerId, ?int $exceptId = null): void
    {
        $exists = Registration::query()
            ->where('aspirant_id', $aspirantId)
            ->where('offer_id', $offerId)
            ->where('estado', '!=', 'Cancelada')
            ->when($exceptId, fn ($query) => $query->where('id', '!=', $exceptId))
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'offer_id' => 'Ya existe una inscripción activa para esta oferta.',
            ]);
        }
    }

    private function loadRelations(Registration $inscripcion): Registration
    {
        return $inscripcion->load(['offer.program', 'aspirant.user']);
    }
}
