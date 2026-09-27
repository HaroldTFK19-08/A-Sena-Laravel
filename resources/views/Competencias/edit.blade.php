@extends('Layouts.Usuarios.AppAdmin')
@section('titulo', 'Editar competencia')
@section('contenido')<h1 class="admin-title">Editar competencia</h1>@include('Competencias.form', ['action'=>route('competencias.update',$competencia), 'method'=>'PUT'])@endsection