<?php

namespace App\Dominios\Resultados\Controllers;

use App\Dominios\Competencias\Models\Competition;
use App\Dominios\Resultados\Models\Grade;
use App\Dominios\Resultados\Models\Result;
use App\Dominios\Resultados\Requests\ResultRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $resultados = Result::query()
            ->with(['competition'])
            ->withCount('grades')
            ->when($request->filled('buscar'), function ($consulta) use ($request) {
                $buscar = $request->buscar;
                $consulta->where(function ($filtro) use ($buscar) {
                    $filtro->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('codigo', 'like', "%{$buscar}%")
                        ->orWhereHas('competition', function ($competencia) use ($buscar) {
                            $competencia->where('nombre', 'like', "%{$buscar}%");
                        });
                });
            })
            ->when($request->filled('competencia'), function ($consulta) use ($request) {
                $consulta->where('competition_id', $request->competencia);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $competencias = Competition::orderBy('nombre')->get();

        $resumen = [
            'total_resultados' => Result::count(),
            'total_calificaciones' => Grade::count(),
            'aprobados' => Grade::query()->where('estado_resultado', 'Aprobado')->count(),
            'pendientes' => Grade::query()->where('estado_resultado', 'Pendiente')->count(),
        ];

        return view('Resultados.index', compact('resultados', 'competencias', 'resumen'));
    }

    public function create()
    {
        return view('Resultados.create', [
            'competencias' => Competition::orderBy('nombre')->get(),
        ]);
    }

    public function store(ResultRequest $request)
    {
        $datos = $request->validated();
        $cantidad = max(1, (int) ($datos['cantidad'] ?? 1));
        unset($datos['cantidad']);

        for ($indice = 1; $indice <= $cantidad; $indice++) {
            Result::create([
                'competition_id' => $datos['competition_id'],
                'codigo' => $this->codigoResultado($datos['codigo'] ?? null, $indice, $cantidad),
                'nombre' => $cantidad === 1 ? $datos['nombre'] : trim($datos['nombre'].' '.$indice),
                'descripcion' => $datos['descripcion'] ?? null,
            ]);
        }

        $mensaje = $cantidad === 1
            ? 'Resultado creado correctamente.'
            : "Se configuraron {$cantidad} resultados correctamente.";

        return redirect()->route('resultados.index')->with('success', $mensaje);
    }

    public function show(Result $resultado)
    {
        $resultado->load(['competition', 'grades.apprentice.user', 'grades.teacher.user']);

        $resumen = [
            'aprobados' => $resultado->grades->where('estado_resultado', 'Aprobado')->count(),
            'reprobados' => $resultado->grades->where('estado_resultado', 'Reprobado')->count(),
            'pendientes' => $resultado->grades->where('estado_resultado', 'Pendiente')->count(),
        ];

        return view('Resultados.show', compact('resultado', 'resumen'));
    }

    public function edit(Result $resultado)
    {
        return view('Resultados.edit', [
            'resultado' => $resultado,
            'competencias' => Competition::orderBy('nombre')->get(),
        ]);
    }

    public function update(ResultRequest $request, Result $resultado)
    {
        $datos = $request->validated();
        unset($datos['cantidad']);

        $resultado->update($datos);

        return redirect()->route('resultados.index')->with('success', 'Resultado actualizado correctamente.');
    }

    public function destroy(Result $resultado)
    {
        if (! $resultado->puedeEliminarse()) {
            return redirect()
                ->route('resultados.index')
                ->with('error', 'No se puede eliminar el resultado porque ya tiene calificaciones asociadas.');
        }

        $resultado->delete();

        return redirect()->route('resultados.index')->with('success', 'Resultado eliminado correctamente.');
    }

    private function codigoResultado(?string $codigo, int $indice, int $cantidad): ?string
    {
        if (! $codigo) {
            return null;
        }

        return $cantidad === 1 ? $codigo : $codigo.'-'.$indice;
    }
}
