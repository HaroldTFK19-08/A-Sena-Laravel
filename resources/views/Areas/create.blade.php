@extends('Layouts.Usuarios.AppAdmin')
@section('titulo', 'Nueva Área')
@section('contenido')
    @include('Areas.partials.styles')
    <div class="space-y-8">
        {{-- Encabezado --}}
        <section class="admin-hero">
            <div>
                <p class="admin-eyebrow">
                    Gestión institucional
                </p>
                <h1 class="admin-title">
                    Registrar área
                </h1>
                <p class="admin-description">
                    Crea un área académica y asígnala a un centro de formación.
                </p>
            </div>
            <a
                href="{{ route('areas.index') }}"
                class="admin-secondary"
            >
                Volver al listado
            </a>
        </section>
        {{-- Formulario --}}
        <section class="admin-panel">
            <h2 class="admin-heading mb-6">
                Datos del área
            </h2>
            @include('Areas.partials.form', [
                'action' => route('areas.store'),
                'method' => 'POST',
                'area' => null
            ])
        </section>
    </div>
@endsection