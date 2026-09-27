<?php

namespace App\Dominios\Inscripciones\Controllers;

use App\Dominios\Inscripciones\Models\Registration;
use App\Dominios\Inscripciones\Requests\AspirantRegistrationRequest;
use App\Dominios\Ofertas\Models\Offer;
use App\Dominios\Usuarios\Models\Aspirant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AspirantRegistrationController extends Controller
{
    public function ofertas(Request $request)
    {
        $aspirante = $this->aspiranteActual();

        $ofertas = Offer::query()
            ->with('program')
            ->withCount(['inscriptions as inscripciones_activas_count' => function ($consulta) {
                $consulta->where('estado', '!=', 'Cancelada');
            }])
            ->where('publicada', true)
            ->when($request->filled('buscar'), function ($consulta) use ($request) {
                $buscar = $request->buscar;
                $consulta->whereHas('program', function ($programa) use ($buscar) {
                    $programa->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('codigo_programa', 'like', "%{$buscar}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $inscripciones = $this->inscripcionesPorOferta($aspirante);

        return view('Inscripciones.Aspirante.ofertas', compact('ofertas', 'inscripciones'));
    }

    public function oferta(Offer $oferta)
    {
        abort_unless($oferta->publicada, 404);

        $aspirante = $this->aspiranteActual();
        $oferta->load('program');
        $oferta->loadCount(['inscriptions as inscripciones_activas_count' => function ($consulta) {
            $consulta->where('estado', '!=', 'Cancelada');
        }]);

        $inscripcion = $aspirante
            ? $this->inscripcionesPorOferta($aspirante)->get($oferta->id)
            : null;

        return view('Inscripciones.Aspirante.oferta', compact('oferta', 'inscripcion'));
    }

    public function resultados()
    {
        $aspirante = $this->aspiranteActual(true);

        $inscripciones = $aspirante->inscriptions()
            ->with(['offer.program'])
            ->latest('Fecha_inscripcion')
            ->paginate(10);

        $resumen = [
            'seleccionadas' => $aspirante->inscriptions()->where('estado', 'Seleccionado')->count(),
            'en_proceso' => $aspirante->inscriptions()->whereIn('estado', ['Registrado', 'En proceso'])->count(),
            'rechazadas' => $aspirante->inscriptions()->where('estado', 'Rechazado')->count(),
        ];

        return view('Inscripciones.Aspirante.resultados', compact('inscripciones', 'resumen'));
    }

    public function index()
    {
        $aspirante = $this->aspiranteActual(true);

        $inscripciones = $aspirante->inscriptions()
            ->with(['offer.program'])
            ->latest('Fecha_inscripcion')
            ->paginate(10);

        $resumen = [
            'total' => $aspirante->inscriptions()->count(),
            'en_proceso' => $aspirante->inscriptions()->whereIn('estado', ['Registrado', 'En proceso'])->count(),
            'seleccionadas' => $aspirante->inscriptions()->where('estado', 'Seleccionado')->count(),
            'canceladas' => $aspirante->inscriptions()->whereIn('estado', ['Cancelada', 'Rechazado'])->count(),
        ];

        return view('Inscripciones.Aspirante.index', compact('inscripciones', 'resumen'));
    }

    public function create(Request $request)
    {
        $aspirante = $this->aspiranteActual(true);
        abort_unless($request->filled('oferta'), 404);
        $oferta = Offer::with('program')->findOrFail($request->query('oferta'));

        $this->asegurarOfertaAbierta($oferta);
        $this->asegurarInscripcionUnica($aspirante->id, $oferta->id);

        return view('Inscripciones.Aspirante.create', [
            'oferta' => $oferta,
            'aspirante' => $aspirante->load('user'),
        ]);
    }

    public function store(AspirantRegistrationRequest $request)
    {
        $aspirante = $this->aspiranteActual(true);
        $oferta = Offer::findOrFail($request->integer('offer_id'));

        $this->asegurarOfertaAbierta($oferta);
        $this->asegurarInscripcionUnica($aspirante->id, $oferta->id);
        $this->actualizarDocumentos($request, $aspirante);

        $inscripcion = Registration::create([
            'aspirant_id' => $aspirante->id,
            'offer_id' => $oferta->id,
            'estado' => 'Registrado',
            'Fecha_inscripcion' => now(),
        ]);

        return redirect()
            ->route('aspirante.inscripciones.show', $inscripcion)
            ->with('success', 'Inscripción registrada correctamente.');
    }

    public function show(Registration $inscripcion)
    {
        $this->autorizarInscripcion($inscripcion);
        $inscripcion->load(['offer.program', 'aspirant.user']);

        return view('Inscripciones.Aspirante.show', compact('inscripcion'));
    }

    public function edit(Registration $inscripcion)
    {
        $this->autorizarInscripcion($inscripcion);
        abort_unless($inscripcion->permiteEdicion(), 403, 'Esta inscripción ya no permite modificaciones.');

        $inscripcion->load(['offer.program', 'aspirant.user']);
        $ofertas = Offer::with('program')->where('publicada', true)->latest()->get();

        return view('Inscripciones.Aspirante.edit', compact('inscripcion', 'ofertas'));
    }

    public function update(AspirantRegistrationRequest $request, Registration $inscripcion)
    {
        $this->autorizarInscripcion($inscripcion);
        abort_unless($inscripcion->permiteEdicion(), 403, 'Esta inscripción ya no permite modificaciones.');

        $oferta = Offer::findOrFail($request->integer('offer_id'));

        if ((int) $oferta->id !== (int) $inscripcion->offer_id) {
            $this->asegurarOfertaAbierta($oferta);
            $this->asegurarInscripcionUnica($inscripcion->aspirant_id, $oferta->id, $inscripcion->id);
        }

        $this->actualizarDocumentos($request, $inscripcion->aspirant);

        $inscripcion->update([
            'offer_id' => $oferta->id,
        ]);

        return redirect()
            ->route('aspirante.inscripciones.show', $inscripcion)
            ->with('success', 'Inscripción actualizada correctamente.');
    }

    public function cancelar(Registration $inscripcion)
    {
        $this->autorizarInscripcion($inscripcion);
        abort_unless($inscripcion->permiteCancelacion(), 403, 'Esta inscripción no puede cancelarse.');

        $inscripcion->update(['estado' => 'Cancelada']);

        return redirect()
            ->route('aspirante.inscripciones.index')
            ->with('success', 'La inscripción fue cancelada.');
    }

    private function inscripcionesPorOferta(?Aspirant $aspirante)
    {
        if (! $aspirante) {
            return collect();
        }

        return $aspirante->inscriptions()
            ->latest('Fecha_inscripcion')
            ->get()
            ->groupBy('offer_id')
            ->map(function ($grupo) {
                return $grupo->first(fn (Registration $inscripcion) => $inscripcion->estaActiva())
                    ?? $grupo->first();
            });
    }

    private function aspiranteActual(bool $obligatorio = false): ?Aspirant
    {
        $aspirante = auth()->user()?->aspirant;

        if ($obligatorio && ! $aspirante) {
            abort(403, 'Debes completar tu perfil de aspirante para continuar.');
        }

        return $aspirante;
    }

    private function autorizarInscripcion(Registration $inscripcion): void
    {
        $aspirante = $this->aspiranteActual(true);
        abort_unless((int) $inscripcion->aspirant_id === (int) $aspirante->id, 403);
    }

    private function asegurarOfertaAbierta(Offer $oferta): void
    {
        if (! $oferta->estaAbierta()) {
            throw ValidationException::withMessages([
                'offer_id' => 'Esta oferta no admite nuevas inscripciones.',
            ]);
        }
    }

    private function asegurarInscripcionUnica(int $aspirantId, int $offerId, ?int $exceptId = null): void
    {
        $existe = Registration::query()
            ->where('aspirant_id', $aspirantId)
            ->where('offer_id', $offerId)
            ->where('estado', '!=', 'Cancelada')
            ->when($exceptId, fn ($consulta) => $consulta->where('id', '!=', $exceptId))
            ->exists();

        if ($existe) {
            throw ValidationException::withMessages([
                'offer_id' => 'Ya tienes una inscripción activa en esta oferta.',
            ]);
        }
    }

    private function actualizarDocumentos(AspirantRegistrationRequest $request, Aspirant $aspirante): void
    {
        $documentos = [];

        foreach (['certificado_eps', 'certificado_bachiller', 'certificado_icfes'] as $documento) {
            if ($request->hasFile($documento)) {
                $documentos[$documento] = $request->file($documento)->store('documents', 'public');
            }
        }

        if ($documentos !== []) {
            $aspirante->update($documentos);
        }
    }
}
