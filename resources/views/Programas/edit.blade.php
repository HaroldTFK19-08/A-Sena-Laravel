@extends('Layouts.Usuarios.AppAdmin')
@section('titulo','Editar Programa')
@section('contenido')
@include('Areas.partials.styles')
<div class="space-y-8"><section class="admin-hero"><div><p class="admin-eyebrow">Gestión académica</p><h1 class="admin-title">Editar programa</h1><p class="admin-description">Actualiza la información de {{ $programa->nombre }}.</p></div><a href="{{ route('programas.index') }}" class="admin-secondary">Volver al listado</a></section><section class="admin-panel"><h2 class="admin-heading mb-6">Datos del programa</h2>@include('Programas.partials.form',['action'=>route('programas.update',$programa),'method'=>'PUT'])</section></div>
@endsection
