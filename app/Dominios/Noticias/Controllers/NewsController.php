<?php

namespace App\Dominios\Noticias\Controllers;
use App\Dominios\Noticias\Requests\NewRequest;
use App\Dominios\Noticias\Models\News;
use App\Dominios\Centros\Models\Trainingcenter;
use App\Dominios\Usuarios\Models\Admin;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    //
    public function create(){   
        $centros = Trainingcenter::all();
        return view('Noticias.create',compact('centros'));
    }
    public function store(NewRequest $request)
    {
        $data = $request->validated(); 
        $data['admin_id'] = Admin::where('user_id', auth()->id())->value('id');
        $data['imagen'] = $request->file('imagen')?->store('news', 'public'); 
        News::create($data); 
        return redirect() ->route('noticias.index') ->with('success', 'Noticia creada con éxito');
    }
    public function index(){
        $noticias = News::orderBy('id','desc')->get();
        return view('Noticias.index',compact('noticias'));
    }
    public function show(News $noticia) { 
        $noticia->load('trainingcenter'); 
        return view('Noticias.show', compact('noticia')); } 
    public function edit(News $noticia) { 
        $centros = Trainingcenter::all(); 
        return view('Noticias.edit', compact('noticia', 'centros')); 
    } public function update(NewRequest $request, News $noticia) { 
        $data = $request->validated(); 
        if ($request->hasFile('imagen')) { 
            $data['imagen'] = $request->file('imagen')->store('news', 'public'); 
        } $noticia->update($data);
        return redirect() ->route('noticias.index')->with('success', 'Noticia actualizada con éxito'); 
    } 
    public function destroy(News $noticia) { 
        $noticia->delete(); 
        return redirect() ->route('noticias.index')->with('success', 'Noticia eliminada con éxito'); 
    }
}
