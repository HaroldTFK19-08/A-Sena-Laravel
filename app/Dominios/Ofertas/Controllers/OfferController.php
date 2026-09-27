<?php

namespace App\Dominios\Ofertas\Controllers;

use App\Http\Controllers\Controller;
use App\Dominios\Ofertas\Models\Offer;
use App\Dominios\Usuarios\Models\Admin;
use App\Dominios\Programas\Models\Program;
use App\Dominios\Ofertas\Requests\OfferRequest;

class OfferController extends Controller
{
    public function create()
    {
        $programas = Program::all();
        return view('Ofertas.create', compact('programas'));
    }
    public function store(OfferRequest $request)
    {
        $datos = $request->validated();
        $datos['admin_id'] = Admin::where('user_id', auth()->id())->value('id');
        $datos['imagen'] = $request->file('imagen')?->store('offers', 'public');
        Offer::create($datos);
        return redirect()->route('ofertas.index')->with('success', 'Oferta creada con éxito');
    }
    public function index()
    {
        $ofertas = Offer::orderBy('id', 'desc')->get();
        return view('Ofertas.index', compact('ofertas'));
    }
    public function show(Offer $oferta)
    {
        $oferta->load('program');
        return view('Ofertas.show', compact('oferta'));
    }
    public function edit(Offer $oferta)
    {
        $programas = Program::all();
        return view('Ofertas.edit', compact('oferta', 'programas'));
    }
    public function update(OfferRequest $request, Offer $oferta)
    {
        $datos = $request->validated();
        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('offers', 'public');
        }
        $oferta->update($datos);
        return redirect()->route('ofertas.index')->with('success', 'Oferta actualizada con éxito');
    }
    public function destroy(Offer $oferta)
    {
        $oferta->delete();
        return redirect()->route('ofertas.index')->with('success', 'Oferta eliminada con éxito');
    }
    public function publicar(Offer $oferta)
    {
        $oferta->update([
            'publicada' => true,
        ]);
        return redirect()->route('auth.ofertas')->with('success', 'La oferta ha sido publicada correctamente.');
    }
    public function despublicar(Offer $oferta)
    {
        $oferta->update([
            'publicada' => false,
        ]);
        return redirect()->route('auth.ofertas')->with('success', 'La oferta ha sido retirada de publicación.');
    }
}
