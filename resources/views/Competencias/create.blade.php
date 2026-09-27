```blade
@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Nueva competencia')

@section('contenido')
    @include('Competencias.form', [
        'competencia' => null,
        'action' => route('competencias.store'),
        'method' => 'POST',
    ])
@endsection
