@extends('Layouts.Auth.AppLogin')

@section('titulo', 'Iniciar Sesión')

@section('contenido')
    @include('Includes.Auth.LoginForm')
@endsection
