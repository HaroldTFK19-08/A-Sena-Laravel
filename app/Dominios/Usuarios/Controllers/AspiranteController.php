<?php

namespace App\Dominios\Usuarios\Controllers;

use App\Dominios\Usuarios\Models\User;
use App\Dominios\Usuarios\Requests\PerfilAspiranteRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AspiranteController extends Controller
{
    public function home()
    {
        /** @var User $usuario */
        $usuario = auth()->user();
        $nombre_1 = $usuario->nombre_1 ?? 'Aspirante';
        $aspirante = $usuario->aspirant()->with('inscriptions')->first();
        $totalInscripciones = $aspirante
            ? $aspirante->inscriptions()->where('estado', '!=', 'Cancelada')->count()
            : 0;

        $documentosCompletos = 0;
        if ($aspirante) {
            $camposDocumentos = [
                'eps',
                'certificado_eps',
                'certificado_bachiller',
                'certificado_icfes',
            ];
            foreach ($camposDocumentos as $campo) {
                if (! empty($aspirante->{$campo})) {
                    $documentosCompletos++;
                }
            }
        }

        $estadoProceso = $aspirante?->inscriptions()
            ->where('estado', '!=', 'Cancelada')
            ->latest('Fecha_inscripcion')
            ->value('estado') ?: 'Sin inscripción activa';
        $avanceDocumentos = $documentosCompletos > 0
            ? min(100, ($documentosCompletos / 4) * 100)
            : 0;

        return view('Usuarios.Aspirantes.homeAspirante', [
            'nombre_1' => $nombre_1,
            'aspirante' => $aspirante,
            'totalInscripciones' => $totalInscripciones,
            'documentosCompletos' => $documentosCompletos,
            'avanceDocumentos' => $avanceDocumentos,
            'estadoProceso' => $estadoProceso,
        ]);
    }

    public function fechas()
    {
        $aspirante = auth()->user()?->aspirant;
        if (! $aspirante) {
            return view('Usuarios.Aspirantes.fechas', [
                'inscripciones' => collect(),
                'eventos' => collect(),
                'proximos' => collect(),
                'resumen' => ['total' => 0, 'proximos' => 0, 'inscripciones' => 0, 'activas' => 0],
            ]);
        }

        $inscripciones = $aspirante->inscriptions()
            ->with(['offer.program'])
            ->latest('Fecha_inscripcion')
            ->get();

        $eventos = collect();
        foreach ($inscripciones as $inscripcion) {
            $oferta = $inscripcion->offer;
            $programa = $oferta?->program?->nombre ?? 'Programa no disponible';

            if ($inscripcion->Fecha_inscripcion) {
                $eventos->push([
                    'fecha' => Carbon::parse($inscripcion->Fecha_inscripcion),
                    'titulo' => 'Inscripción registrada',
                    'descripcion' => $programa,
                    'tipo' => 'Mi inscripción',
                    'estado' => $inscripcion->estado,
                    'ruta' => route('aspirante.inscripciones.show', $inscripcion),
                ]);
            }

            $hitos = [
                ['fecha' => $oferta?->fecha_lanzamiento, 'titulo' => 'Lanzamiento de la oferta', 'tipo' => 'Convocatoria'],
                ['fecha' => $oferta?->fecha_convocatoria, 'titulo' => 'Inicio de convocatoria', 'tipo' => 'Convocatoria'],
                ['fecha' => $oferta?->fecha_fin_convocatoria, 'titulo' => 'Cierre de convocatoria', 'tipo' => 'Convocatoria'],
                ['fecha' => $oferta?->fecha_primera_prueba, 'titulo' => 'Primera prueba', 'tipo' => 'Selección'],
                ['fecha' => $oferta?->fecha_segunda_prueba, 'titulo' => 'Segunda prueba', 'tipo' => 'Selección'],
                ['fecha' => $oferta?->fecha_seleccionados, 'titulo' => 'Publicación de seleccionados', 'tipo' => 'Resultado'],
            ];

            foreach ($hitos as $hito) {
                if (! $hito['fecha']) {
                    continue;
                }

                $eventos->push([
                    'fecha' => Carbon::parse($hito['fecha']),
                    'titulo' => $hito['titulo'],
                    'descripcion' => $programa,
                    'tipo' => $hito['tipo'],
                    'estado' => $inscripcion->estado,
                    'ruta' => route('aspirante.inscripciones.show', $inscripcion),
                ]);
            }
        }

        $eventos = $eventos->sortBy('fecha')->values();
        $proximos = $eventos->filter(fn (array $evento) => $evento['fecha']->isToday() || $evento['fecha']->isFuture());
        $inscripcionesActivas = $inscripciones->where('estado', '!=', 'Cancelada');

        $resumen = [
            'total' => $eventos->count(),
            'proximos' => $proximos->count(),
            'inscripciones' => $inscripciones->count(),
            'activas' => $inscripcionesActivas->count(),
        ];

        return view('Usuarios.Aspirantes.fechas', compact('inscripciones', 'eventos', 'proximos', 'resumen'));
    }

    public function perfil()
    {
        /** @var User $usuario */
        $usuario = auth()->user();
        $usuario->load(['aspirant.inscriptions.offer']);

        return view('Usuarios.Aspirantes.perfilAspirante', compact('usuario'));
    }

    public function edit()
    {
        /** @var User $usuario */
        $usuario = User::findOrFail(auth()->id());
        $usuario->load('aspirant');

        return view('Usuarios.Aspirantes.editAspirante', compact('usuario'));
    }

    public function update(PerfilAspiranteRequest $request)
    {
        /** @var User $usuario */
        $usuario = auth()->user();
        $datos = $request->validated();

        $usuario->update([
            'nombre_1' => $datos['nombre_1'],
            'nombre_2' => $datos['nombre_2'] ?? null,
            'apellido_1' => $datos['apellido_1'],
            'apellido_2' => $datos['apellido_2'] ?? null,
            'tipo_identificacion' => $datos['tipo_identificacion'],
            'identificacion' => $datos['identificacion'],
            'email' => $datos['email'],
        ]);

        if ($request->hasFile('foto_perfil')) {
            $usuario->update(['foto_perfil' => $request->file('foto_perfil')->store('photos', 'public')]);
        }

        $datosAspirante = ['eps' => $datos['eps']];
        foreach (['certificado_eps', 'certificado_bachiller', 'certificado_icfes'] as $documento) {
            if ($request->hasFile($documento)) {
                $datosAspirante[$documento] = $request->file($documento)->store('documents', 'public');
            }
        }

        $usuario->aspirant()->updateOrCreate(['user_id' => $usuario->id], $datosAspirante);

        return redirect()->route('aspirante.perfil')->with('success', 'Perfil actualizado correctamente.');
    }
}
