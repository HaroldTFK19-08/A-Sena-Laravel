@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Editar perfil de aspirante')

@section('contenido')
    @include('Usuarios.partials.formularioPerfil', [
        'rol' => 'Aspirante',
        'color' => '#FFB0A5',
        'action' => route('aspirante.update'),
        'backRoute' => route('aspirante.perfil'),
    ])
@endsection
