@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Detalle de oferta')

@section('contenido')
    <div class="space-y-8">
        <section class="rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 md:p-8">
            <a href="{{ route('aspirante.ofertas.index') }}" class="text-sm font-semibold text-[#0E6B54]">Volver a ofertas</a>
            <p class="mt-4 text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Oferta de formación</p>
            <h1 class="mt-3 text-3xl font-black text-[#0A2334]">{{ $oferta->program?->nombre }}</h1>
            <div class="mt-4 flex flex-wrap gap-2">
                @if ($oferta->estaAbierta())
                    <span class="rounded-full bg-[#D8F7CB] px-3 py-1 text-xs font-bold text-[#0E6B54]">Abierta</span>
                @else
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">Cerrada</span>
                @endif
                @if ($inscripcion)
                    @include('Inscripciones.partials.estado', ['estado' => $inscripcion->estado])
                @endif
            </div>
        </section>

        <section class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6">
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Convocatoria</p>
                <div class="mt-4 space-y-2 text-sm text-[#45616F]">
                    <p>Lanzamiento: {{ optional($oferta->fecha_lanzamiento)->format('d/m/Y') ?? 'Sin fecha' }}</p>
                    <p>Inicio: {{ optional($oferta->fecha_convocatoria)->format('d/m/Y') ?? 'Sin fecha' }}</p>
                    <p>Cierre: {{ optional($oferta->fecha_fin_convocatoria)->format('d/m/Y') ?? 'Sin fecha' }}</p>
                    <p>Capacidad: {{ $oferta->capacidad ?? 'Sin límite' }}</p>
                    <p>Inscritos activos: {{ $oferta->inscripcionesActivasCount() }}</p>
                </div>
            </div>
            <div class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6">
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Pruebas y selección</p>
                <div class="mt-4 space-y-2 text-sm text-[#45616F]">
                    <p>Primera prueba: {{ optional($oferta->fecha_primera_prueba)->format('d/m/Y') ?? 'Por definir' }}</p>
                    <p>Segunda prueba: {{ optional($oferta->fecha_segunda_prueba)->format('d/m/Y') ?? 'Por definir' }}</p>
                    <p>Publicación de seleccionados: {{ optional($oferta->fecha_seleccionados)->format('d/m/Y') ?? 'Por definir' }}</p>
                </div>
            </div>
        </section>

        <div class="flex flex-wrap gap-3">
            @if ($inscripcion && ! $inscripcion->estaCancelada())
                <a href="{{ route('aspirante.inscripciones.show', $inscripcion) }}" class="rounded-xl bg-[#0E6B54] px-5 py-3 text-sm font-bold text-white">Ver mi inscripción</a>
            @elseif ($oferta->estaAbierta())
                <a href="{{ route('aspirante.inscripciones.create', ['oferta' => $oferta->id]) }}" class="rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30]">Inscribirme</a>
            @endif
        </div>
    </div>
@endsection
