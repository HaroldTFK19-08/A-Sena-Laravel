@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Detalle de inscripción')

@section('contenido')
    <div class="space-y-8">
        <section class="rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 md:p-8">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Mi inscripción</p>
                    <h1 class="mt-3 text-3xl font-black text-[#0A2334]">{{ $inscripcion->offer?->program?->nombre }}</h1>
                    <div class="mt-4">@include('Inscripciones.partials.estado', ['estado' => $inscripcion->estado])</div>
                </div>
                <div class="flex flex-wrap gap-3">
                    @if ($inscripcion->permiteEdicion())
                        <a href="{{ route('aspirante.inscripciones.edit', $inscripcion) }}" class="rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30]">Editar</a>
                    @endif
                    @if ($inscripcion->permiteCancelacion())
                        <form method="POST" action="{{ route('aspirante.inscripciones.cancelar', $inscripcion) }}" onsubmit="return confirm('¿Deseas cancelar esta inscripción?');">
                            @csrf
                            @method('PATCH')
                            <button class="rounded-xl border border-red-200 bg-white px-5 py-3 text-sm font-bold text-red-600" type="submit">Cancelar inscripción</button>
                        </form>
                    @endif
                </div>
            </div>
        </section>

        @if (session('success'))
            <div class="p-4 rounded-2xl bg-[#D8F7CB] text-[#0E6B54] border border-[#BCE6B0] text-sm font-semibold">{{ session('success') }}</div>
        @endif

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 md:p-8">
            <p class="mb-5 text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Seguimiento del proceso</p>
            @include('Inscripciones.partials.seguimiento', ['estado' => $inscripcion->estado])
            @if ($inscripcion->estado === 'Seleccionado')
                <p class="mt-5 rounded-2xl bg-[#EAFBF0] px-4 py-3 text-sm font-semibold text-[#0E6B54]">¡Felicidades! Fuiste seleccionado en esta oferta. Espera indicaciones de tu centro de formación.</p>
            @elseif ($inscripcion->estado === 'Rechazado')
                <p class="mt-5 rounded-2xl bg-red-50 px-4 py-3 text-sm font-semibold text-red-600">Esta inscripción no fue seleccionada en esta oferta. Puedes explorar otras convocatorias disponibles.</p>
            @endif
        </section>

        <section class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6">
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Aspirante</p>
                <div class="mt-4 space-y-2 text-sm text-[#45616F]">
                    <p>{{ $inscripcion->aspirant?->user?->nombre_completo }}</p>
                    <p>{{ $inscripcion->aspirant?->user?->tipo_identificacion }} {{ $inscripcion->aspirant?->user?->identificacion }}</p>
                    <p>{{ $inscripcion->aspirant?->user?->email }}</p>
                </div>
            </div>
            <div class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6">
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Oferta</p>
                <div class="mt-4 space-y-2 text-sm text-[#45616F]">
                    <p>Fecha de inscripción: {{ $inscripcion->Fecha_inscripcion?->format('d/m/Y H:i') }}</p>
                    <p>Convocatoria: {{ optional($inscripcion->offer?->fecha_convocatoria)->format('d/m/Y') }} - {{ optional($inscripcion->offer?->fecha_fin_convocatoria)->format('d/m/Y') }}</p>
                    <p>Capacidad: {{ $inscripcion->offer?->capacidad ?? 'Sin límite' }}</p>
                    <p>Publicada: {{ $inscripcion->offer?->publicada ? 'Sí' : 'No' }}</p>
                    <p>Primera prueba: {{ optional($inscripcion->offer?->fecha_primera_prueba)->format('d/m/Y') ?? 'Por definir' }}</p>
                    <p>Segunda prueba: {{ optional($inscripcion->offer?->fecha_segunda_prueba)->format('d/m/Y') ?? 'Por definir' }}</p>
                    <p>Seleccionados: {{ optional($inscripcion->offer?->fecha_seleccionados)->format('d/m/Y') ?? 'Por definir' }}</p>
                </div>
            </div>
        </section>

        @include('Inscripciones.partials.documentos', ['inscripcion' => $inscripcion])
    </div>
@endsection
