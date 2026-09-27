@extends('Layouts.Usuarios.AppAdmin')
@section('titulo', 'Editar Equipo')
@section('contenido')
    @include('Areas.partials.styles')
    <div class="space-y-8">
        <section class="admin-hero">
            <div>
                <p class="admin-eyebrow">Gestión institucional</p>
                <h1 class="admin-title">Editar equipo</h1>
                <p class="admin-description">Actualiza la información de {{ $equipo->name }}.</p>
            </div><a href="{{ route('equipos.index') }}" class="admin-secondary">Volver al listado</a>
        </section>
        <section class="admin-panel">
            <h2 class="admin-heading mb-6">Datos del equipo</h2>@include('Equipos.partials.form', [
                'action' => route('equipos.update', $equipo),
                'method' => 'PUT',
            ])
        </section>
    </div>
@endsection
