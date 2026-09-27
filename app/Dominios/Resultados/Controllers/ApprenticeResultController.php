<?php

namespace App\Dominios\Resultados\Controllers;

use App\Dominios\Resultados\Models\Grade;
use App\Http\Controllers\Controller;

class ApprenticeResultController extends Controller
{
    public function index()
    {
        $aprendiz = auth()->user()?->apprentice;
        abort_unless($aprendiz, 403, 'Debes completar tu perfil de aprendiz para consultar resultados.');

        $calificaciones = Grade::query()
            ->with(['result.competition', 'teacher.user'])
            ->where('apprentice_id', $aprendiz->id)
            ->latest()
            ->paginate(12);

        $resumen = [
            'total' => Grade::query()->where('apprentice_id', $aprendiz->id)->count(),
            'aprobados' => Grade::query()->where('apprentice_id', $aprendiz->id)->where('estado_resultado', 'Aprobado')->count(),
            'reprobados' => Grade::query()->where('apprentice_id', $aprendiz->id)->where('estado_resultado', 'Reprobado')->count(),
            'pendientes' => Grade::query()->where('apprentice_id', $aprendiz->id)->where('estado_resultado', 'Pendiente')->count(),
        ];

        return view('Resultados.Aprendiz.index', compact('calificaciones', 'resumen', 'aprendiz'));
    }
}
