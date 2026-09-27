@extends('Layouts.Auth.AppInicio')

@section('titulo', $oferta->program?->nombre ?? 'Oferta de formación')

@section('contenido')

<section class="bg-[#081B28] py-12 md:py-20">

    <div class="mx-auto max-w-6xl px-6 lg:px-8">

        <a
            href="{{ route('auth.ofertas') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-[#8AFD5D] transition hover:text-white"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7 7-7-7 7-7" />
            </svg>
            Volver a ofertas
        </a>

        <div class="mt-8 overflow-hidden rounded-[32px] border border-white/10 bg-[#0A2A3F]/70">

            @if ($oferta->imagen)
                <img
                    src="{{ asset('storage/' . $oferta->imagen) }}"
                    alt="{{ $oferta->program?->nombre ?? 'Oferta de formación' }}"
                    class="h-72 w-full object-cover md:h-96"
                >
            @else
                <div class="flex h-72 items-center justify-center bg-[#001E30] md:h-96">
                    <svg class="h-24 w-24 text-[#8AFD5D]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif

            <div class="p-6 md:p-10">

                <div class="flex flex-wrap items-center gap-3">
                    <span class="rounded-full bg-[#8AFD5D]/10 px-3 py-1.5 text-[10px] font-bold uppercase tracking-[0.2em] text-[#8AFD5D]">
                        Oferta publicada
                    </span>
                    @if ($oferta->program?->area)
                        <span class="text-xs text-slate-400">
                            {{ $oferta->program->area->nombre }}
                        </span>
                    @endif
                </div>

                <h1 class="mt-5 text-3xl font-black leading-tight text-white md:text-5xl">
                    {{ $oferta->program?->nombre ?? 'Oferta de formación' }}
                </h1>

                <p class="mt-4 max-w-3xl text-base leading-7 text-slate-300">
                    Conoce el programa, las fechas de la convocatoria y la disponibilidad de cupos para esta formación.
                </p>

                <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-wider text-slate-400">Código</p>
                        <p class="mt-2 font-bold text-white">{{ $oferta->program?->codigo_programa ?? 'No disponible' }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-wider text-slate-400">Centro</p>
                        <p class="mt-2 font-bold text-white">{{ $oferta->program?->area?->trainingcenter?->nombre ?? 'No disponible' }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-wider text-slate-400">Cupos totales</p>
                        <p class="mt-2 text-2xl font-black text-[#8AFD5D]">{{ $oferta->capacidad ?? 'Sin límite' }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-wider text-slate-400">Inscripciones activas</p>
                        <p class="mt-2 text-2xl font-black text-white">{{ $oferta->inscripciones_activas_count ?? 0 }}</p>
                    </div>
                </div>

                <h2 class="mt-10 text-xl font-black text-white">Cronograma de la convocatoria</h2>

                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    @foreach ([
                        ['Lanzamiento', $oferta->fecha_lanzamiento],
                        ['Inicio de convocatoria', $oferta->fecha_convocatoria],
                        ['Cierre de convocatoria', $oferta->fecha_fin_convocatoria],
                        ['Primera prueba', $oferta->fecha_primera_prueba],
                        ['Segunda prueba', $oferta->fecha_segunda_prueba],
                        ['Selección de participantes', $oferta->fecha_seleccionados],
                    ] as $hito)
                        @if ($hito[1])
                            <div class="flex items-center justify-between gap-4 rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                                <span class="text-sm text-slate-400">{{ $hito[0] }}</span>
                                <span class="text-sm font-bold text-white">{{ \Carbon\Carbon::parse($hito[1])->format('d/m/Y') }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                    @auth
                        @if (auth()->user()->rol === 'Aspirante')
                            <a
                                href="{{ route('aspirante.ofertas.show', $oferta) }}"
                                class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-6 py-3 text-sm font-extrabold text-[#001E30] transition hover:bg-[#72db4c]"
                            >
                                Gestionar mi inscripción
                            </a>
                        @else
                            <a
                                href="{{ route('auth.login') }}"
                                class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-6 py-3 text-sm font-extrabold text-[#001E30] transition hover:bg-[#72db4c]"
                            >
                                Iniciar sesión para inscribirme
                            </a>
                        @endif
                    @else
                        <a
                            href="{{ route('auth.login') }}"
                            class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-6 py-3 text-sm font-extrabold text-[#001E30] transition hover:bg-[#72db4c]"
                        >
                            Iniciar sesión para inscribirme
                        </a>
                    @endauth

                    <a
                        href="{{ route('auth.ofertas') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-white/15 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/5"
                    >
                        Volver al catálogo
                    </a>
                </div>

            </div>

        </div>

    </div>

</section>

@endsection
