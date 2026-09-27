@extends('Layouts.Auth.AppInicio')

@section('contenido')

<section class="bg-[#081B28] py-16 md:py-20">

    <div class="mx-auto max-w-7xl px-6 lg:px-8">

        <div class="mb-12 text-center">

            <span class="inline-flex rounded-full border border-[#8AFD5D]/20 bg-[#8AFD5D]/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-[#8AFD5D]">
                Formación disponible
            </span>

            <h1 class="mt-5 text-4xl font-black tracking-tight text-white md:text-5xl">
                Ofertas de formación
            </h1>

            <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-slate-400 md:text-base">
                Consulta todas las ofertas de formación disponibles y conoce sus fechas y cupos.
            </p>

        </div>


        {{-- BUSCADOR --}}

        <div class="mb-12 rounded-3xl border border-white/10 bg-[#0A2A3F]/70 p-5 shadow-xl">

            <form
                action="{{ route('auth.ofertas.buscar') }}"
                method="GET"
                class="grid gap-4 md:grid-cols-[1fr_auto_auto]"
            >
                <div class="relative">
                    <svg
                        class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-500"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                    </svg>
                    <input
                        type="search"
                        name="buscar"
                        value="{{ request('buscar', request('titulo')) }}"
                        placeholder="Buscar por programa, código o área..."
                        class="w-full rounded-2xl border border-white/10 bg-[#081B28] py-3.5 pl-12 pr-4 text-sm text-white outline-none transition placeholder:text-slate-500 focus:border-[#8AFD5D]/50 focus:ring-2 focus:ring-[#8AFD5D]/10"
                    >
                </div>

                <button
                    type="submit"
                    class="rounded-2xl bg-[#39A900] px-6 py-3.5 text-sm font-bold text-white transition hover:bg-[#2f8f00] active:scale-[0.98]"
                >
                    Buscar
                </button>

                @if (request()->filled('buscar') || request()->filled('titulo'))
                    <a
                        href="{{ route('auth.ofertas') }}"
                        class="inline-flex items-center justify-center rounded-2xl border border-white/15 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-white/5"
                    >
                        Limpiar
                    </a>
                @endif
            </form>

        </div>


        {{-- OFERTAS --}}

        <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8AFD5D]">
                    Convocatorias
                </p>

                <h2 class="mt-2 text-2xl font-black text-white md:text-3xl">
                    Todas las ofertas
                </h2>

            </div>

            <span class="w-fit rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold text-slate-400">
                {{ $ofertas->count() }}
                {{ $ofertas->count() === 1 ? 'oferta disponible' : 'ofertas disponibles' }}
            </span>

        </div>


        <div class="grid gap-7 md:grid-cols-2 xl:grid-cols-3">

            @forelse ($ofertas as $oferta)

                <article class="group overflow-hidden rounded-[28px] border border-white/10 bg-[#0A2A3F]/70 shadow-lg transition duration-300 hover:-translate-y-1 hover:border-[#8AFD5D]/30 hover:shadow-2xl">

                    {{-- IMAGEN --}}

                    @if ($oferta->imagen)

                        <div class="relative h-52 overflow-hidden">

                            <img
                                src="{{ asset('storage/' . $oferta->imagen) }}"
                                alt="Oferta de formación"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                            >

                            <div class="absolute inset-0 bg-gradient-to-t from-[#081B28] via-transparent to-transparent"></div>

                        </div>

                    @else

                        <div class="flex h-52 items-center justify-center bg-gradient-to-br from-[#0A2A3F] to-[#001E30]">

                            <svg
                                class="h-14 w-14 text-[#8AFD5D]/30"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M21 13.255A23.931 23.931 0 0 1 12 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2m4 6h.01M5 20h14a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h14a2 2 0 0 0 2 2v10a2 2 0 0 0 2 2Z"
                                />
                            </svg>

                        </div>

                    @endif


                    <div class="p-6">

                        <div class="flex items-center justify-between gap-3">

                            <span class="rounded-full bg-[#8AFD5D]/10 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-[#8AFD5D]">
                                Oferta de formación
                            </span>

                            @if ($oferta->capacidad)

                                <span class="text-xs font-semibold text-slate-400">
                                    {{ $oferta->capacidad }} cupos
                                </span>

                            @endif

                        </div>


                        <h3 class="mt-5 text-xl font-bold leading-snug text-white transition group-hover:text-[#8AFD5D]">
                            <a href="{{ route('auth.ofertas.show', $oferta) }}">
                                {{ $oferta->program?->nombre ?? 'Oferta de formación' }}
                            </a>
                        </h3>


                        <div class="mt-6 space-y-3">

                            @if ($oferta->fecha_lanzamiento)

                                <div class="flex items-center justify-between rounded-2xl bg-white/5 px-4 py-3">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#8AFD5D]/10">

                                            <svg
                                                class="h-4 w-4 text-[#8AFD5D]"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z"
                                                />
                                            </svg>

                                        </div>

                                        <span class="text-xs text-slate-400">
                                            Lanzamiento
                                        </span>

                                    </div>

                                    <span class="text-xs font-semibold text-white">
                                        {{ \Carbon\Carbon::parse($oferta->fecha_lanzamiento)->format('d/m/Y') }}
                                    </span>

                                </div>

                            @endif


                            @if ($oferta->fecha_convocatoria)

                                <div class="flex items-center justify-between rounded-2xl bg-white/5 px-4 py-3">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#8AFD5D]/10">

                                            <svg
                                                class="h-4 w-4 text-[#8AFD5D]"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z"
                                                />
                                            </svg>

                                        </div>

                                        <span class="text-xs text-slate-400">
                                            Convocatoria
                                        </span>

                                    </div>

                                    <span class="text-xs font-semibold text-white">
                                        {{ \Carbon\Carbon::parse($oferta->fecha_convocatoria)->format('d/m/Y') }}
                                    </span>

                                </div>

                            @endif


                            @if ($oferta->fecha_primera_prueba)

                                <div class="flex items-center justify-between rounded-2xl bg-white/5 px-4 py-3">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#8AFD5D]/10">

                                            <svg
                                                class="h-4 w-4 text-[#8AFD5D]"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h14a2 2 0 0 0 2 2v12a2 2 0 0 0-2 2Z"
                                                />
                                            </svg>

                                        </div>

                                        <span class="text-xs text-slate-400">
                                            Primera prueba
                                        </span>

                                    </div>

                                    <span class="text-xs font-semibold text-white">
                                        {{ \Carbon\Carbon::parse($oferta->fecha_primera_prueba)->format('d/m/Y') }}
                                    </span>

                                </div>

                            @endif


                            @if ($oferta->fecha_seleccionados)

                                <div class="flex items-center justify-between rounded-2xl bg-white/5 px-4 py-3">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#8AFD5D]/10">

                                            <svg
                                                class="h-4 w-4 text-[#8AFD5D]"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h14a2 2 0 0 0 2 2v12a2 2 0 0 0-2 2Z"
                                                />
                                            </svg>

                                        </div>

                                        <span class="text-xs text-slate-400">
                                            Seleccionados
                                        </span>

                                    </div>

                                    <span class="text-xs font-semibold text-white">
                                        {{ \Carbon\Carbon::parse($oferta->fecha_seleccionados)->format('d/m/Y') }}
                                    </span>

                                </div>

                            @endif

                        </div>


                        @if ($oferta->capacidad)

                            <div class="mt-5 flex items-center justify-between border-t border-white/10 pt-5">

                                <span class="text-sm text-slate-400">
                                    Cupos disponibles
                                </span>

                                <span class="text-lg font-black text-[#8AFD5D]">
                                    {{ $oferta->capacidad }}
                                </span>

                            </div>

                        @endif

                        <a
                            href="{{ route('auth.ofertas.show', $oferta) }}"
                            class="mt-5 inline-flex items-center gap-2 text-xs font-bold text-[#8AFD5D] transition hover:text-white"
                        >
                            Ver oferta completa
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0-5 5m5-5H6" />
                            </svg>
                        </a>

                    </div>

                </article>

            @empty

                <div class="col-span-full flex min-h-[350px] items-center justify-center">

                    <div class="w-full max-w-lg rounded-[30px] border border-white/10 bg-[#0A2A3F]/60 p-10 text-center">

                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-white/5">

                            <svg
                                class="h-10 w-10 text-[#8AFD5D]/40"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M21 13.255A23.931 23.931 0 0 1 12 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2m4 6h.01M5 20h14a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h14a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z"
                                />
                            </svg>

                        </div>

                        <h3 class="mt-6 text-lg font-bold text-white">
                            No hay ofertas disponibles
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-400">
                            Actualmente no hay ofertas de formación publicadas.
                        </p>

                    </div>

                </div>

            @endforelse

        </div>

    </div>

</section>

@endsection