<?php

namespace App\Dominios\Auth\Controllers;

use App\Dominios\Noticias\Models\News;
use App\Dominios\Ofertas\Models\Offer;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OfertasyNoticiasController extends Controller
{
    public function noticias()
    {
        $noticias = $this->noticiasPublicas()
            ->with('trainingcenter')
            ->latest()
            ->get();

        return view('Auth.noticias', compact('noticias'));
    }

    public function buscarNoticias(Request $request)
    {
        $titulo = trim((string) $request->input('titulo'));
        $categoria = trim((string) $request->input('categoria'));

        $noticias = $this->noticiasPublicas()
            ->with('trainingcenter')
            ->when($titulo, function (Builder $query) use ($titulo) {
                $query->where('titulo', 'like', "%{$titulo}%");
            })
            ->when($categoria, function (Builder $query) use ($categoria) {
                $query->where('categoria', $categoria);
            })
            ->latest()
            ->get();

        return view('Auth.noticias', compact('noticias'));
    }

    public function noticia(News $noticia)
    {
        abort_unless($this->noticiaEsPublica($noticia), 404);

        $noticia->load(['trainingcenter', 'admin.user']);

        return view('Auth.noticia', compact('noticia'));
    }

    public function previa()
    {
        $previa = $this->noticiasPublicas()
            ->latest()
            ->take(3)
            ->get();

        $previaOfertas = $this->ofertasPublicas()
            ->with('program')
            ->latest()
            ->take(3)
            ->get();

        return view('Auth.inicio', compact('previa', 'previaOfertas'));
    }

    public function ofertas(Request $request)
    {
        return $this->buscarOfertas($request);
    }

    public function buscarOfertas(Request $request)
    {
        $buscar = trim((string) $request->input('buscar', $request->input('titulo')));

        $ofertas = $this->ofertasPublicas()
            ->with('program.area.trainingcenter')
            ->when($buscar, function (Builder $query) use ($buscar) {
                $query->whereHas('program', function (Builder $programa) use ($buscar) {
                    $programa->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('codigo_programa', 'like', "%{$buscar}%")
                        ->orWhereHas('area', function (Builder $area) use ($buscar) {
                            $area->where('nombre', 'like', "%{$buscar}%");
                        });
                });
            })
            ->latest()
            ->get();

        return view('Auth.ofertas', compact('ofertas'));
    }

    public function oferta(Offer $oferta)
    {
        abort_unless($oferta->publicada, 404);

        $oferta->load(['program.area.trainingcenter', 'admin.user'])
            ->loadCount([
                'inscriptions as inscripciones_activas_count' => function ($query) {
                    $query->where('estado', '!=', 'Cancelada');
                },
            ]);

        return view('Auth.oferta', compact('oferta'));
    }

    private function noticiasPublicas(): Builder
    {
        return News::query()
            ->where('publicada', true)
            ->where('estado', 'Publicado');
    }

    private function ofertasPublicas(): Builder
    {
        return Offer::query()->where('publicada', true);
    }

    private function noticiaEsPublica(News $noticia): bool
    {
        return (bool) $noticia->publicada && $noticia->estado === 'Publicado';
    }
}
