@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Editar perfil de instructor')

@section('contenido')
    @include('Usuarios.partials.formularioPerfil', [
        'rol' => 'Instructor',
        'color' => '#8FB4FF',
        'action' => route('instructor.update'),
        'backRoute' => route('instructor.perfil'),
    ])
@endsection
