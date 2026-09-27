@extends('Layouts.Usuarios.AppAdmin')
@section('titulo', 'Nuevo Equipo')
@section('contenido')
    @include('Areas.partials.styles')
    <div class="space-y-8">
        <section class="admin-hero">
            <div>
                <p class="admin-eyebrow">Gestión institucional</p>
                <h1 class="admin-title">Registrar equipo</h1>
                <p class="admin-description">Agrega un equipo al inventario de un ambiente.</p>
            </div><a href="{{ route('equipos.index') }}" class="admin-secondary">Volver al listado</a>
        </section>
        <section class="admin-panel">
            <h2 class="admin-heading mb-6">Datos del equipo</h2>@include('Equipos.partials.form', [
                'action' => route('equipos.store'),
                'method' => 'POST',
                'equipo' => null,
            ])
        </section>
    </div>
@endsection
