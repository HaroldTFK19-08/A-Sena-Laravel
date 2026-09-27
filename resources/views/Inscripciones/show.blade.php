@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Detalle de inscripción')

@section('contenido')
    <div class="space-y-8">
        <section class="rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 md:p-8">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Admisión</p>
                    <h1 class="mt-3 text-3xl font-black text-[#0A2334]">Detalle de inscripción</h1>
                    <div class="mt-4">@include('Inscripciones.partials.estado', ['estado' => $inscripcion->estado])</div>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('inscripciones.edit', $inscripcion) }}" class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30]">Editar</a>
                    <form method="POST" action="{{ route('inscripciones.destroy', $inscripcion) }}" onsubmit="return confirm('¿Eliminar esta inscripción?');">
                        @csrf
                        @method('DELETE')
                        <button class="inline-flex items-center justify-center rounded-xl border border-red-200 bg-white px-5 py-3 text-sm font-bold text-red-600" type="submit">Eliminar</button>
                    </form>
                </div>
            </div>
        </section>

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 md:p-8">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex-1">
                    <p class="mb-4 text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Seguimiento del proceso</p>
                    @include('Inscripciones.partials.seguimiento', ['estado' => $inscripcion->estado])
                </div>
                <form method="POST" action="{{ route('inscripciones.estado', $inscripcion) }}" class="flex items-end gap-2">
                    @csrf
                    @method('PATCH')
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold uppercase tracking-[0.14em] text-[#5F7785]">Cambiar estado</label>
                        <select name="estado" class="h-11 rounded-xl border border-[#D8E6EB] bg-white px-3 text-sm outline-none focus:border-[#8AFD5D]">
                            @foreach ($estados as $estadoOpcion)
                                <option value="{{ $estadoOpcion }}" @selected($inscripcion->estado === $estadoOpcion)>{{ $estadoOpcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="h-11 rounded-xl bg-[#0E6B54] px-4 text-sm font-bold text-white hover:bg-[#0a5a46]">Actualizar</button>
                </form>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6">
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Aspirante</p>
                <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">{{ $inscripcion->aspirant?->user?->nombre_completo }}</h2>
                <div class="mt-4 space-y-2 text-sm text-[#45616F]">
                    <p>Identificación: {{ $inscripcion->aspirant?->user?->tipo_identificacion }} {{ $inscripcion->aspirant?->user?->identificacion }}</p>
                    <p>Correo: {{ $inscripcion->aspirant?->user?->email }}</p>
                    <p>EPS: {{ $inscripcion->aspirant?->eps ?? 'Sin registrar' }}</p>
                </div>
            </div>
            <div class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6">
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Oferta</p>
                <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">{{ $inscripcion->offer?->program?->nombre }}</h2>
                <div class="mt-4 space-y-2 text-sm text-[#45616F]">
                    <p>Fecha de inscripción: {{ $inscripcion->Fecha_inscripcion?->format('d/m/Y H:i') }}</p>
                    <p>Convocatoria: {{ optional($inscripcion->offer?->fecha_convocatoria)->format('d/m/Y') }} - {{ optional($inscripcion->offer?->fecha_fin_convocatoria)->format('d/m/Y') }}</p>
                    <p>Situación: {{ $inscripcion->estaCancelada() ? 'Cancelada' : 'Activa' }}</p>
                    <p>Capacidad: {{ $inscripcion->offer?->capacidad ?? 'Sin límite' }}</p>
                    <p>Publicada: {{ $inscripcion->offer?->publicada ? 'Sí' : 'No' }}</p>
                    <p>Primera prueba: {{ optional($inscripcion->offer?->fecha_primera_prueba)->format('d/m/Y') ?? 'Por definir' }}</p>
                    <p>Seleccionados: {{ optional($inscripcion->offer?->fecha_seleccionados)->format('d/m/Y') ?? 'Por definir' }}</p>
                </div>
            </div>
        </section>

        @include('Inscripciones.partials.documentos', ['inscripcion' => $inscripcion])
    </div>
@endsection
