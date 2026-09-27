@extends('Layouts.Usuarios.AppAdmin')
@section('titulo', 'Detalle del Equipo')
@section('contenido')
    @include('Areas.partials.styles')
    <div class="space-y-8">
        <section class="admin-hero">
            <div>
                <p class="admin-eyebrow">Inventario institucional</p>
                <h1 class="admin-title">{{ $equipo->name }}</h1>
                <p class="admin-description">{{ $equipo->environment?->nombre ?? 'Sin ambiente asignado' }}</p>
            </div>
            <div class="flex gap-3"><a href="{{ route('equipos.edit', $equipo) }}" class="admin-primary">Editar equipo</a><a
                    href="{{ route('equipos.index') }}" class="admin-secondary">Volver</a></div>
        </section>
        <section class="grid gap-5 md:grid-cols-3">
            <div class="admin-stat">
                <p>Marca</p><strong class="text-xl">{{ $equipo->brand ?: 'Sin marca' }}</strong><small>Fabricante
                    registrado</small>
            </div>
            <div class="admin-stat">
                <p>Tipo</p><strong class="text-xl">{{ $equipo->equipment_type }}</strong><small>Clasificación del
                    equipo</small>
            </div>
            <div class="admin-stat">
                <p>Ambiente</p><strong
                    class="text-xl">{{ $equipo->environment?->nombre ?? 'Sin ambiente' }}</strong><small>{{ $equipo->environment?->trainingcenter?->nombre ?? 'Sin centro' }}</small>
            </div>
        </section>
        <section class="admin-panel">
            <h2 class="admin-heading">Información del equipo</h2>
            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4">
                    <p class="form-label">Nombre</p>
                    <p class="font-bold text-[#0A2334]">{{ $equipo->name }}</p>
                </div>
                <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4">
                    <p class="form-label">Registrado el</p>
                    <p class="font-bold text-[#0A2334]">{{ $equipo->created_at?->translatedFormat('d M Y') }}</p>
                </div>
            </div>
        </section>
    </div>
@endsection
