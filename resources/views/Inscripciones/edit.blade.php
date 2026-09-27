@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Editar inscripción')

@section('contenido')
    @include('Inscripciones.form', [
        'action' => route('inscripciones.update', $inscripcion),
        'method' => 'PUT',
        'titulo' => 'Editar inscripción',
    ])
@endsection
