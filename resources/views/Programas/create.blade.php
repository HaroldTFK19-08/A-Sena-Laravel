@extends('Layouts.Usuarios.AppAdmin')
@section('titulo', 'Nuevo Programa')
@section('contenido')
    @include('Areas.partials.styles')
    <div class="space-y-8">
        <section class="admin-hero">
            <div>
                <p class="admin-eyebrow">Gestión académica</p>
                <h1 class="admin-title">Registrar programa</h1>
                <p class="admin-description">Crea un nuevo programa de formación.</p>
            </div><a href="{{ route('programas.index') }}" class="admin-secondary">Volver al listado</a>
        </section>
        <section class="admin-panel">
            <h2 class="admin-heading mb-6">Datos del programa</h2>
            @include('Programas.partials.form', [
                'action' => route('programas.store'),
                'method' => 'POST',
                'programa' => null,
            ])
        </section>
    </div>
@endsection
