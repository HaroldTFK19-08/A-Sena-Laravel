@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Nueva inscripción')

@section('contenido')
    <h1 class="admin-title hidden">Nueva inscripción</h1>
    @include('Inscripciones.form', [
        'inscripcion' => null,
        'action' => route('inscripciones.store'),
        'method' => 'POST',
        'titulo' => 'Nueva inscripción',
    ])
@endsection
