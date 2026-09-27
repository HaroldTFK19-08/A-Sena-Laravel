<?php

namespace App\Dominios\Ambientes\Controllers;

use App\Http\Controllers\Controller;
use App\Dominios\Ambientes\Models\Environment;

class ConsultasController extends Controller
{
    //
    public function consulta1(){
        $ambientes =  Environment::where('nombre','Cocina didáctica')->with('trainingcenter')->get();
        return response()->json($ambientes);
    }
}
