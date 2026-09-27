@extends('Layouts.Usuarios.AppAdmin')
@section('titulo', 'Equipos')
@section('contenido')
    @include('Areas.partials.styles')
    <div class="space-y-8">
        <section class="admin-hero">
            <div>
                <p class="admin-eyebrow">Gestión institucional</p>
                <h1 class="admin-title">Equipos</h1>
                <p class="admin-description">Controla los equipos asignados a los ambientes de formación.</p>
            </div><a href="{{ route('equipos.create') }}" class="admin-primary">+ Nuevo equipo</a>
        </section>
        @if (session('success'))
            <div class="admin-success">{{ session('success') }}</div>
        @endif
        <section class="grid gap-5 md:grid-cols-3">
            <div class="admin-stat">
                <p>Equipos registrados</p><strong>{{ $equipos->count() }}</strong><small>Total de equipos</small>
            </div>
            <div class="admin-stat">
                <p>Marcas</p><strong>{{ $equipos->pluck('brand')->filter()->unique()->count() }}</strong><small>Marcas
                    identificadas</small>
            </div>
            <div class="admin-stat">
                <p>Ambientes cubiertos</p>
                <strong>{{ $equipos->pluck('environment_id')->unique()->count() }}</strong><small>Ambientes con
                    equipos</small>
            </div>
        </section>
        <section class="admin-panel">
            <div class="mb-5">
                <p class="admin-eyebrow">Inventario</p>
                <h2 class="admin-heading mt-2">Todos los equipos</h2>
            </div>
            @if ($equipos->isEmpty())
                <div class="admin-empty">Aún no hay equipos registrados. <a href="{{ route('equipos.create') }}">Crear el
                    primero</a></div>@else<div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Equipo</th>
                                <th>Marca</th>
                                <th>Tipo</th>
                                <th>Ambiente</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($equipos as $equipo)
                                <tr>
                                    <td><span
                                            class="admin-avatar">{{ strtoupper(substr($equipo->name, 0, 1)) }}</span><b>{{ $equipo->name }}</b>
                                    </td>
                                    <td>{{ $equipo->brand ?: 'Sin marca' }}</td>
                                    <td>{{ $equipo->equipment_type }}</td>
                                    <td>{{ $equipo->environment?->nombre ?? 'Sin ambiente' }}</td>
                                    <td>
                                        <div class="admin-actions">
                                            <a href="{{ route('equipos.show', $equipo) }}">Ver</a>
                                            <a href="{{ route('equipos.edit', $equipo) }}">Editar</a>
                                            <form method="POST" action="{{ route('equipos.destroy', $equipo) }}" onsubmit="return confirm('¿Eliminar este equipo?');">
                                                @csrf
                                                @method('DELETE')
                                                <button>Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
@endsection
