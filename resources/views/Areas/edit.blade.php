@extends('Layouts.Usuarios.AppAdmin')
@section('titulo', 'Editar Área')
@section('contenido')
@include('Areas.partials.styles')
<div class="space-y-8"><section class="admin-hero"><div><p class="admin-eyebrow">Gestión institucional</p><h1 class="admin-title">Editar área</h1><p class="admin-description">Actualiza la información de {{ $area->nombre }}.</p></div><a href="{{ route('areas.index') }}" class="admin-secondary">Volver al listado</a></section><section class="admin-panel"><h2 class="admin-heading mb-6">Datos del área</h2>@include('Areas.partials.form', ['action' => route('areas.update', $area), 'method' => 'PUT'])</section></div>
@endsection
