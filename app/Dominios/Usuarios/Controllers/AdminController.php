<?php

namespace App\Dominios\Usuarios\Controllers;

use App\Http\Controllers\Controller;
use App\Dominios\Centros\Models\Trainingcenter;
use App\Dominios\Usuarios\Models\Apprentice;
use App\Dominios\Usuarios\Models\User;
use App\Dominios\Usuarios\Request\PerfilAdminRequest;

class AdminController extends Controller
{
    //
    public function home(){
        $user = auth()->user();
        $nombre_1 = $user->nombre_1;
        $totalCentros = Trainingcenter::count();
        $totalAprendices = User::where("rol","Aprendiz")->count();
        return view('Usuarios.Admin.homeAdmin', compact(
            'totalCentros',
            'totalAprendices',
            'nombre_1'
        ));
    }

    public function perfil()
    {
        /** @var User $usuario */
        $usuario = auth()->user();
        $usuario->load('admin');
        return view('Usuarios.Admin.perfilAdmin', compact('usuario'));
    }
    public function edit()
    {
        /** @var User $usuario */
        $usuario = User::findOrFail(auth()->id());
        $usuario->load('admin');
        return view('Usuarios.Admin.edit', compact('usuario'));
    }
    public function update(PerfilAdminRequest $request){
        /** @var User $usuario */
        $usuario = auth()->user();
        $datos = $request->validated();
        $usuario->update($datos);
        if ($request->hasFile('foto_perfil')) {
            $usuario->update([
                'foto_perfil' => $request->file('foto_perfil')->store('photos', 'public')
            ]);
        }
        $usuario->admin()->updateOrCreate(
            ['user_id' => $usuario->id],
            $datos
        );
        return redirect()->route('admin.perfil')->with('success', 'Perfil actualizado correctamente.');
    }
}
