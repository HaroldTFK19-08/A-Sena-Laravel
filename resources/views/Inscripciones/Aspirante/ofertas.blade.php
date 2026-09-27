@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Ofertas de formación')

@section('contenido')
    <div class="space-y-8">
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#EAF5F4] via-[#F1F8F7] to-[#E9F0F7] p-6 md:p-8 shadow-[0_20px_45px_rgba(15,40,53,0.08)]">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Admisión</p>
            <h1 class="mt-3 text-3xl font-black text-[#0A2334]">Ofertas de formación</h1>
            <p class="mt-3 max-w-2xl text-sm text-[#3b5d6e]">Consulta las convocatorias publicadas e inscríbete cuando la oferta esté abierta.</p>
        </section>

        @if (session('success'))
            <div class="p-4 rounded-2xl bg-[#D8F7CB] text-[#0E6B54] border border-[#BCE6B0] text-sm font-semibold">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-red-50 text-red-600 border border-red-200 text-sm font-semibold">{{ $errors->first() }}</div>
        @endif

        <form method="GET" class="rounded-[24px] border border-[#D8E6EB] bg-white p-5 flex flex-col gap-3 sm:flex-row">
            <input type="search" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por programa"
                class="h-12 w-full rounded-2xl border border-[#D8E6EB] px-4 text-sm outline-none focus:border-[#8AFD5D]">
            <button class="h-12 rounded-2xl bg-[#0E6B54] px-5 text-sm font-bold text-white">Buscar</button>
        </form>

        @if ($ofertas->isEmpty())
            <div class="rounded-2xl border border-dashed border-[#D8E6EB] bg-white p-10 text-center text-sm text-[#5F7785]">
                No hay ofertas publicadas en este momento.
            </div>
        @else
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                @foreach ($ofertas as $oferta)
                    @php
                        $inscripcion = $inscripciones->get($oferta->id);
                    @endphp
                    <article class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                        <h2 class="text-xl font-extrabold text-[#0A2334]">{{ $oferta->program?->nombre }}</h2>
                        <p class="mt-2 text-sm text-[#5F7785]">Cierra: {{ optional($oferta->fecha_fin_convocatoria)->format('d/m/Y') ?? 'Sin fecha' }}</p>
                        <div class="mt-3">
                            <div class="flex items-center justify-between text-xs text-[#5F7785]">
                                <span>Inscritos</span>
                                <span class="font-semibold text-[#0A2334]">{{ $oferta->inscripcionesActivasCount() }}{{ $oferta->capacidad ? ' / '.$oferta->capacidad : ' (sin límite)' }}</span>
                            </div>
                            @if ($oferta->capacidad)
                                @php
                                    $porcentaje = min(100, (int) round(($oferta->inscripcionesActivasCount() / max(1, $oferta->capacidad)) * 100));
                                @endphp
                                <div class="mt-1.5 h-2 w-full overflow-hidden rounded-full bg-[#EAF1F3]">
                                    <div class="h-full rounded-full {{ $porcentaje >= 100 ? 'bg-red-400' : 'bg-[#39A900]' }}" style="width: {{ $porcentaje }}%"></div>
                                </div>
                            @endif
                        </div>
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
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('aspirante.ofertas.show', $oferta) }}" class="rounded-xl border border-[#D8E6EB] bg-white px-4 py-2 text-xs font-bold text-[#0A2334]">Ver detalle</a>
                            @if ($inscripcion && ! $inscripcion->estaCancelada())
                                <a href="{{ route('aspirante.inscripciones.show', $inscripcion) }}" class="rounded-xl bg-[#0E6B54] px-4 py-2 text-xs font-bold text-white">Ver inscripción</a>
                            @elseif ($oferta->estaAbierta())
                                <a href="{{ route('aspirante.inscripciones.create', ['oferta' => $oferta->id]) }}" class="rounded-xl bg-[#8AFD5D] px-4 py-2 text-xs font-extrabold text-[#001E30]">Inscribirme</a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="mt-4">{{ $ofertas->links() }}</div>
        @endif
    </div>
@endsection
