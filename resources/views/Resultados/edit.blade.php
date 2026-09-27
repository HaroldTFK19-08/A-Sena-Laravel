@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Editar resultado')

@section('contenido')
    @include('Resultados.form', [
        'action' => route('resultados.update', $resultado),
        'method' => 'PUT',
        'titulo' => 'Editar resultado',
    ])
@endsection
