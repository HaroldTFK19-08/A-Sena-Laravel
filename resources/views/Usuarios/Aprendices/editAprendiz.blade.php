@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Editar perfil de aprendiz')

@section('contenido')
    @include('Usuarios.partials.formularioPerfil', [
        'rol' => 'Aprendiz',
        'color' => '#8AFD5D',
        'action' => route('aprendiz.update'),
        'backRoute' => route('aprendiz.perfil'),
    ])
@endsection
