<?php

namespace App\Dominios\Inscripciones\Controllers;

use App\Dominios\Inscripciones\Models\Registration;
use App\Dominios\Inscripciones\Requests\RegistrationRequest;
use App\Dominios\Ofertas\Models\Offer;
use App\Dominios\Usuarios\Models\Aspirant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $inscripciones = Registration::query()
            ->with(['offer.program', 'aspirant.user'])
            ->when($request->filled('buscar'), function ($consulta) use ($request) {
                $buscar = $request->buscar;
                $consulta->whereHas('aspirant.user', function ($usuario) use ($buscar) {
                    $usuario->where('nombre_1', 'like', "%{$buscar}%")
                        ->orWhere('nombre_2', 'like', "%{$buscar}%")
                        ->orWhere('apellido_1', 'like', "%{$buscar}%")
                        ->orWhere('apellido_2', 'like', "%{$buscar}%")
                        ->orWhere('identificacion', 'like', "%{$buscar}%")
                        ->orWhere('email', 'like', "%{$buscar}%");
                });
            })
            ->when($request->filled('oferta'), function ($consulta) use ($request) {
                $consulta->where('offer_id', $request->oferta);
            })
            ->when($request->filled('estado'), function ($consulta) use ($request) {
                $consulta->where('estado', $request->estado);
            })
            ->latest('Fecha_inscripcion')
            ->paginate(10)
            ->withQueryString();

        $ofertas = Offer::with('program')->latest()->get();
        $estados = Registration::ESTADOS;
        $totales = [
            'total' => Registration::count(),
            'activas' => Registration::query()->where('estado', '!=', 'Cancelada')->count(),
            'canceladas' => Registration::query()->where('estado', 'Cancelada')->count(),
        ];

        $porEstado = collect($estados)->mapWithKeys(function ($estado) {
            return [$estado => Registration::query()->where('estado', $estado)->count()];
        });

        return view('Inscripciones.index', compact('inscripciones', 'ofertas', 'estados', 'totales', 'porEstado'));
    }

    public function create()
    {
        return view('Inscripciones.create', [
            'ofertas' => Offer::with('program')->latest()->get(),
            'aspirantes' => Aspirant::with('user')->get(),
            'estados' => Registration::ESTADOS,
        ]);
    }

    public function store(RegistrationRequest $request)
    {
        $this->asegurarInscripcionUnica(
            $request->integer('aspirant_id'),
            $request->integer('offer_id')
        );

        Registration::create([
            ...$request->validated(),
            'Fecha_inscripcion' => $request->Fecha_inscripcion ?: now(),
        ]);

        return redirect()->route('inscripciones.index')->with('success', 'Inscripción creada correctamente.');
    }

    public function show(Registration $inscripcione)
    {
        $inscripcione->load(['offer.program', 'aspirant.user']);

        return view('Inscripciones.show', [
            'inscripcion' => $inscripcione,
            'estados' => Registration::ESTADOS,
        ]);
    }

    public function edit(Registration $inscripcione)
    {
        return view('Inscripciones.edit', [
            'inscripcion' => $inscripcione,
            'ofertas' => Offer::with('program')->latest()->get(),
            'aspirantes' => Aspirant::with('user')->get(),
            'estados' => Registration::ESTADOS,
        ]);
    }

    public function update(RegistrationRequest $request, Registration $inscripcione)
    {
        $this->asegurarInscripcionUnica(
            $request->integer('aspirant_id'),
            $request->integer('offer_id'),
            $inscripcione->id
        );

        $inscripcione->update($request->validated());

        return redirect()->route('inscripciones.index')->with('success', 'Inscripción actualizada correctamente.');
    }

    public function destroy(Registration $inscripcione)
    {
        $inscripcione->delete();

        return redirect()->route('inscripciones.index')->with('success', 'Inscripción eliminada correctamente.');
    }

    public function cambiarEstado(Request $request, Registration $inscripcione)
    {
        $request->validate([
            'estado' => ['required', Rule::in(Registration::ESTADOS)],
        ]);

        $inscripcione->update(['estado' => $request->string('estado')->toString()]);

        return redirect()
            ->back()
            ->with('success', 'Estado de la inscripción actualizado a "'.$inscripcione->estado.'".');
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
                'offer_id' => 'El aspirante ya tiene una inscripción activa en esta oferta.',
            ]);
        }
    }
}
