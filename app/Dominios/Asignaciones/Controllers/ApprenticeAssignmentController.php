<?php

namespace App\Dominios\Asignaciones\Controllers;

use App\Dominios\Asignaciones\Models\Assignment;
use App\Dominios\Usuarios\Models\Apprentice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApprenticeAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $estado = $request->string('estado')->toString();
        if (! in_array($estado, ['Activo', 'Inactivo'], true)) {
            $estado = '';
        }

        $aprendiz = auth()->user()?->apprentice;
        if (! $aprendiz) {
            return view('Asignaciones.Aprendiz.index', [
                'asignaciones' => Assignment::query()->whereRaw('1 = 0')->paginate(10),
                'resumen' => ['total' => 0, 'activas' => 0, 'devueltas' => 0],
                'estado' => $estado,
            ]);
        }

        $asignaciones = $this->queryVisibles($aprendiz)
            ->when($estado, fn ($consulta) => $consulta->where('Estado', $estado))
            ->when($request->filled('buscar'), function ($consulta) use ($request) {
                $buscar = trim((string) $request->input('buscar'));
                $consulta->where(function ($filtro) use ($buscar) {
                    $filtro->where('equipment.name', 'like', "%{$buscar}%")
                        ->orWhere('equipment.brand', 'like', "%{$buscar}%")
                        ->orWhere('equipment.equipment_type', 'like', "%{$buscar}%");
                });
            })
            ->latest('fecha_asignacion')
            ->paginate(10)
            ->withQueryString();

        $resumen = [
            'total' => $this->queryVisibles($aprendiz)->count(),
            'activas' => $this->queryVisibles($aprendiz)->where('Estado', 'Activo')->count(),
            'devueltas' => $this->queryVisibles($aprendiz)->whereNotNull('fecha_devolucion')->count(),
        ];

        return view('Asignaciones.Aprendiz.index', compact('asignaciones', 'resumen', 'estado'));
    }

    public function show(Assignment $assignment)
    {
        $aprendiz = $this->aprendizActual();
        abort_unless((int) $assignment->apprentice_id === (int) $aprendiz->id, 403);

        $assignment->load(['equipment.environment', 'apprentice.user', 'apprentice.coursegroup.program']);

        return view('Asignaciones.Aprendiz.show', compact('assignment', 'aprendiz'));
    }

    private function aprendizActual(): Apprentice
    {
        $aprendiz = auth()->user()?->apprentice;
        abort_unless($aprendiz, 403, 'Debes completar tu perfil de aprendiz para consultar tus asignaciones.');

        return $aprendiz;
    }

    private function queryVisibles(Apprentice $aprendiz)
    {
        return Assignment::query()
            ->where('apprentice_id', $aprendiz->id)
            ->with(['equipment.environment']);
    }
}
