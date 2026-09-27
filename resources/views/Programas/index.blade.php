@extends('Layouts.Usuarios.AppAdmin')
@section('titulo', 'Programas de Formación')
@section('contenido')
    @include('Areas.partials.styles')
    <div class="space-y-8">
        <section class="admin-hero">
            <div>
                <p class="admin-eyebrow">Gestión académica</p>
                <h1 class="admin-title">Programas de Formación</h1>
                <p class="admin-description">Administra la oferta académica y sus niveles de formación.</p>
            </div><a href="{{ route('programas.create') }}" class="admin-primary">+ Nuevo programa</a>
        </section>
        @if (session('success'))
            <div class="admin-success">{{ session('success') }}</div>
        @endif
        <section class="grid gap-5 md:grid-cols-3">
            <div class="admin-stat">
                <p>Programas registrados</p><strong>{{ $programas->count() }}</strong><small>Total de programas</small>
            </div>
            <div class="admin-stat">
                <p>Técnicos</p><strong>{{ $programas->where('nivel_programa', 'Tecnico')->count() }}</strong><small>Programas
                    técnicos</small>
            </div>
            <div class="admin-stat">
                <p>Tecnólogos</p>
                <strong>{{ $programas->where('nivel_programa', 'Tecnologo')->count() }}</strong><small>Programas
                    tecnológicos</small>
            </div>
        </section>
        <section class="admin-panel">
            <div class="mb-5">
                <p class="admin-eyebrow">Oferta académica</p>
                <h2 class="admin-heading mt-2">Todos los programas</h2>
            </div>
            @if ($programas->isEmpty())
                <div class="admin-empty">Aún no hay programas registrados. <a href="{{ route('programas.create') }}">Crear
                    el primero</a></div>@else<div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Programa</th>
                                <th>Código</th>
                                <th>Nivel</th>
                                <th>Área</th>
                                <th>Ofertas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($programas as $programa)
                                <tr>
                                    <td><span
                                            class="admin-avatar">{{ strtoupper(substr($programa->nombre, 0, 1)) }}</span><b>{{ $programa->nombre }}</b>
                                    </td>
                                    <td>{{ $programa->codigo_programa }}</td>
                                    <td><span
                                            class="rounded-full bg-[#EAF6F4] px-3 py-1 text-xs font-bold text-[#0E6B54]">{{ $programa->nivel_programa }}</span>
                                    </td>
                                    <td>{{ $programa->area?->nombre ?? 'Sin área' }}</td>
                                    <td>{{ $programa->offerts_count }}</td>
                                    <td>
                                        <div class="admin-actions"><a
                                                href="{{ route('programas.show', $programa) }}">Ver</a><a
                                                href="{{ route('programas.edit', $programa) }}">Editar</a>
                                            <form method="POST" action="{{ route('programas.destroy', $programa) }}"
                                                onsubmit="return confirm('¿Eliminar este programa?');">@csrf
                                                @method('DELETE')<button>Eliminar</button></form>
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
