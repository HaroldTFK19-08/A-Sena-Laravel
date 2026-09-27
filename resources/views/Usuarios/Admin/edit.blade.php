@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Editar perfil de administrador')

@section('contenido')
    @include('Usuarios.partials.formularioPerfil', [
        'rol' => 'Administrador',
        'color' => '#8AFD5D',
        'action' => route('admin.update'),
        'backRoute' => route('admin.perfil'),
    ])
@endsection
