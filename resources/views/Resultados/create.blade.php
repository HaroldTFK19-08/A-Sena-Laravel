@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Nuevo resultado')

@section('contenido')
    @include('Resultados.form', [
        'resultado' => null,
        'action' => route('resultados.store'),
        'method' => 'POST',
        'titulo' => 'Nuevo resultado',
    ])
@endsection
