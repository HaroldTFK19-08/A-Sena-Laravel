@extends('Layouts.Auth.AppInicio')

@section('contenido')

    <section class="relative isolate overflow-hidden border-b border-white/5 bg-[radial-gradient(circle_at_top,_rgba(138,253,93,0.18),_transparent_32%),linear-gradient(180deg,#001E30_0%,#081B28_100%)]">

        <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:42px_42px] opacity-25"></div>

        <div class="absolute left-1/2 top-1/2 h-[420px] w-[420px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-[#8AFD5D]/10 blur-3xl"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-6 py-20 lg:px-8 lg:py-24">

            <div class="grid items-center gap-12 lg:grid-cols-[1.2fr_0.8fr]">

                <div>

                    <span class="inline-flex items-center gap-2 rounded-full border border-[#8AFD5D]/30 bg-[#8AFD5D]/10 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-[0.22em] text-[#8AFD5D] shadow-sm shadow-[#8AFD5D]/10">
                        <span class="h-2 w-2 animate-pulse rounded-full bg-[#8AFD5D]"></span>
                        Formación para la transformación social
                    </span>

                    <h1 class="mt-6 text-4xl font-black uppercase leading-none tracking-tight text-white md:text-5xl lg:text-6xl">
                        Construyendo futuro a través de la
                        <span class="block text-[#8AFD5D]">educación</span>
                    </h1>

                    <p class="mt-6 max-w-2xl text-base leading-relaxed text-slate-300 md:text-lg">
                        Bienvenido al portal institucional del SENA. Gestiona centros, programas, instructores,
                        aprendices y procesos académicos desde una sola plataforma moderna, segura y confiable.
                    </p>

                    <div class="mt-10 grid gap-4 sm:grid-cols-3">

                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur-sm">
                            <p class="text-2xl font-black text-white">+120</p>
                            <p class="mt-1 text-xs uppercase tracking-wide text-slate-400">Programas</p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur-sm">
                            <p class="text-2xl font-black text-white">+35</p>
                            <p class="mt-1 text-xs uppercase tracking-wide text-slate-400">Centros</p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur-sm">
                            <p class="text-2xl font-black text-white">24/7</p>
                            <p class="mt-1 text-xs uppercase tracking-wide text-slate-400">Acceso</p>
                        </div>

                    </div>

                </div>

                <div class="rounded-[28px] border border-white/10 bg-[#0A2A3F]/70 p-6 shadow-[0_30px_80px_rgba(2,20,35,0.45)] backdrop-blur-md">

                    <div class="flex items-center justify-between border-b border-white/10 pb-4">

                        <div>
                            <p class="text-xs uppercase tracking-[0.22em] text-slate-400">
                                Panel general
                            </p>

                            <h2 class="mt-2 text-xl font-bold text-white">
                                Estado institucional
                            </h2>
                        </div>

                        <span class="inline-flex items-center gap-2 rounded-full bg-[#8AFD5D]/10 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-[#8AFD5D]">
                            <span class="h-2 w-2 rounded-full bg-[#8AFD5D]"></span>
                            Online
                        </span>

                    </div>

                    <div class="mt-6 space-y-4">

                        <div class="rounded-2xl border border-white/10 bg-[#001E30]/70 p-4">

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-300">Aspirantes activos</span>
                                <span class="font-bold text-white">1,248</span>
                            </div>

                            <div class="mt-3 h-2 overflow-hidden rounded-full bg-white/10">
                                <div class="h-full w-[78%] rounded-full bg-[#8AFD5D]"></div>
                            </div>

                        </div>

                        <div class="rounded-2xl border border-white/10 bg-[#001E30]/70 p-4">

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-300">Matrícula vigente</span>
                                <span class="font-bold text-white">92.4%</span>
                            </div>

                            <div class="mt-3 h-2 overflow-hidden rounded-full bg-white/10">
                                <div class="h-full w-[92%] rounded-full bg-[#8AFD5D]"></div>
                            </div>

                        </div>

                        <div class="rounded-2xl border border-white/10 bg-[#001E30]/70 p-4">

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-300">Cursos aprobados</span>
                                <span class="font-bold text-white">3,860</span>
                            </div>

                            <div class="mt-3 h-2 overflow-hidden rounded-full bg-white/10">
                                <div class="h-full w-[65%] rounded-full bg-[#8AFD5D]"></div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <section class="border-b border-white/5 bg-[#081B28] py-20">

        <div class="mx-auto max-w-7xl px-6 lg:px-8">

            <div class="mb-12 text-center">

                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#8AFD5D]">
                    Qué encontrarás
                </p>

                <h2 class="mt-3 text-3xl font-black uppercase tracking-tight text-white">
                    Una plataforma pensada para crecer
                </h2>

            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">

                <div class="rounded-3xl border border-white/10 bg-[#0A2A3F]/50 p-6 transition-all duration-200 hover:-translate-y-1 hover:border-[#8AFD5D]/50">

                    <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[#8AFD5D]/10 text-[#8AFD5D]">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m5-4h1m-1 4h1"
                            />
                        </svg>

                    </div>

                    <h3 class="text-lg font-bold text-white">
                        Gestión institucional
                    </h3>

                    <p class="mt-3 text-sm leading-relaxed text-slate-300">
                        Administra áreas, centros, programas y fichas con una estructura clara y ordenada.
                    </p>

                </div>


                <div class="rounded-3xl border border-white/10 bg-[#0A2A3F]/50 p-6 transition-all duration-200 hover:-translate-y-1 hover:border-[#8AFD5D]/50">

                    <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[#8AFD5D]/10 text-[#8AFD5D]">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 1120 0z"
                            />
                        </svg>

                    </div>

                    <h3 class="text-lg font-bold text-white">
                        Seguimiento en tiempo real
                    </h3>

                    <p class="mt-3 text-sm leading-relaxed text-slate-300">
                        Consulta avances, procesos y estados de formación de manera rápida y eficiente.
                    </p>

                </div>


                <div class="rounded-3xl border border-white/10 bg-[#0A2A3F]/50 p-6 transition-all duration-200 hover:-translate-y-1 hover:border-[#8AFD5D]/50">

                    <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[#8AFD5D]/10 text-[#8AFD5D]">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                            />
                        </svg>

                    </div>

                    <h3 class="text-lg font-bold text-white">
                        Acceso seguro
                    </h3>

                    <p class="mt-3 text-sm leading-relaxed text-slate-300">
                        Cada rol tiene un entorno diferenciado con permisos y navegaciones adaptadas a su contexto.
                    </p>

                </div>


                <div class="rounded-3xl border border-white/10 bg-[#0A2A3F]/50 p-6 transition-all duration-200 hover:-translate-y-1 hover:border-[#8AFD5D]/50">

                    <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[#8AFD5D]/10 text-[#8AFD5D]">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h12"
                            />
                        </svg>

                    </div>

                    <h3 class="text-lg font-bold text-white">
                        Experiencia clara
                    </h3>

                    <p class="mt-3 text-sm leading-relaxed text-slate-300">
                        Interfaces ordenadas, navegación intuitiva y un diseño orientado a la productividad.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <section class="bg-[#081B28] py-20">

        <div class="mx-auto max-w-7xl px-6 lg:px-8">

            <div class="mb-12 flex items-end justify-between gap-6">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#8AFD5D]">
                        Actualidad
                    </p>

                    <h2 class="mt-3 text-3xl font-black uppercase tracking-tight text-white">
                        Noticias recientes
                    </h2>

                </div>

                <a
                    href="{{ route('auth.noticias') }}"
                    class="hidden rounded-xl border border-[#8AFD5D]/30 bg-[#8AFD5D]/10 px-5 py-3 text-sm font-bold text-[#8AFD5D] transition hover:bg-[#8AFD5D]/20 md:inline-flex"
                >
                    Ver todas
                </a>

            </div>
            <div class="grid gap-6 md:grid-cols-3">

                @forelse ($previa as $noticia)

                    <article class="overflow-hidden rounded-3xl border border-white/10 bg-[#0A2A3F]/60 transition-all duration-200 hover:-translate-y-1 hover:border-[#8AFD5D]/40">

                        @if ($noticia->imagen)

                            <img
                                src="{{ asset('storage/' . $noticia->imagen) }}"
                                alt="{{ $noticia->titulo }}"
                                class="h-48 w-full object-cover"
                            >

                        @else

                            <div class="flex h-48 items-center justify-center bg-[#001E30]">

                                <svg class="h-12 w-12 text-[#8AFD5D]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v12a2 2 0 01-2 2z"
                                    />
                                </svg>

                            </div>

                        @endif


                        <div class="p-6">

                            @if ($noticia->categoria)

                                <span class="inline-flex rounded-full bg-[#8AFD5D]/10 px-3 py-1 text-[10px] font-bold uppercase tracking-wide text-[#8AFD5D]">
                                    {{ $noticia->categoria }}
                                </span>

                            @endif


                            <h3 class="mt-4 text-lg font-bold text-white">
                                <a href="{{ route('auth.noticias.show', $noticia) }}">{{ $noticia->titulo }}</a>
                            </h3>


                            @if ($noticia->descripcion)

                                <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-slate-300">
                                    {{ $noticia->descripcion }}
                                </p>

                            @endif


                            <p class="mt-5 text-xs text-slate-500">
                                {{ $noticia->created_at->format('d/m/Y') }}
                            </p>

                        </div>

                    </article>

                @empty

                    <div class="col-span-full flex min-h-[220px] items-center justify-center">

                        <div class="w-full max-w-md rounded-3xl border border-white/10 bg-[#0A2A3F]/50 p-10 text-center">

                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/5">

                                <svg class="h-8 w-8 text-[#8AFD5D]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v12a2 2 0 012 2v12a2 2 0 012 2V6a2 2 0 012 2v12a2 2 0 01-2 2z"
                                    />

                                </svg>

                            </div>

                            <p class="mt-5 text-base font-semibold text-white">
                                No hay noticias disponibles
                            </p>

                            <p class="mt-2 text-sm text-slate-400">
                                Actualmente no hay noticias publicadas para mostrar.
                            </p>

                        </div>

                    </div>

                @endforelse

            </div>


            <div class="mt-8 text-center md:hidden">

                <a
                    href="{{ route('auth.noticias') }}"
                    class="inline-flex rounded-xl border border-[#8AFD5D]/30 bg-[#8AFD5D]/10 px-5 py-3 text-sm font-bold text-[#8AFD5D]"
                >
                    Ver todas las noticias
                </a>

            </div>

        </div>

    </section>


    <section class="bg-[#001E30] py-20">

        <div class="mx-auto max-w-7xl px-6 lg:px-8">

            <div class="mb-12 flex items-end justify-between gap-6">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#8AFD5D]">
                        Oportunidades
                    </p>

                    <h2 class="mt-3 text-3xl font-black uppercase tracking-tight text-white">
                        Ofertas recientes
                    </h2>

                </div>


                <a
                    href="{{ route('auth.ofertas') }}"
                    class="hidden rounded-xl border border-[#8AFD5D]/30 bg-[#8AFD5D]/10 px-5 py-3 text-sm font-bold text-[#8AFD5D] transition hover:bg-[#8AFD5D]/20 md:inline-flex"
                >
                    Ver todas
                </a>

            </div>


            <div class="grid gap-6 md:grid-cols-3">

                @forelse ($previaOfertas as $oferta)

                    <article class="rounded-3xl border border-white/10 bg-[#0A2A3F]/60 p-6 transition-all duration-200 hover:-translate-y-1 hover:border-[#8AFD5D]/40">

                        <div class="flex items-start justify-between gap-4">

                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#8AFD5D]/10 text-[#8AFD5D]">

                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H3a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    />
                                </svg>

                            </div>


                            @if ($oferta->fecha_convocatoria)

                                <span class="rounded-full bg-[#8AFD5D]/10 px-3 py-1 text-[10px] font-bold uppercase text-[#8AFD5D]">
                                    Convocatoria
                                </span>

                            @endif

                        </div>


                        <h3 class="mt-6 text-xl font-bold text-white">
                            <a href="{{ route('auth.ofertas.show', $oferta) }}">{{ $oferta->program?->nombre ?? 'Oferta de formación' }}</a>
                        </h3>


                        @if ($oferta->program?->area)

                            <p class="mt-3 line-clamp-2 text-sm leading-relaxed text-slate-300">
                                {{ $oferta->program->area->nombre }} · {{ $oferta->program->nivel_programa }}
                            </p>

                        @endif


                        <div class="mt-6 space-y-3 border-t border-white/10 pt-5">

                            @if ($oferta->fecha_lanzamiento)

                                <div class="flex items-center justify-between text-sm">

                                    <span class="text-slate-400">
                                        Lanzamiento
                                    </span>

                                    <span class="font-semibold text-white">
                                        {{ \Carbon\Carbon::parse($oferta->fecha_lanzamiento)->format('d/m/Y') }}
                                    </span>

                                </div>

                            @endif


                            @if ($oferta->fecha_convocatoria)

                                <div class="flex items-center justify-between text-sm">

                                    <span class="text-slate-400">
                                        Convocatoria
                                    </span>

                                    <span class="font-semibold text-white">
                                        {{ \Carbon\Carbon::parse($oferta->fecha_convocatoria)->format('d/m/Y') }}
                                    </span>

                                </div>

                            @endif


                            @if ($oferta->capacidad)

                                <div class="flex items-center justify-between text-sm">

                                    <span class="text-slate-400">
                                        Cupos
                                    </span>

                                    <span class="font-semibold text-[#8AFD5D]">
                                        {{ $oferta->capacidad }}
                                    </span>

                                </div>

                            @endif

                        </div>

                        <a
                            href="{{ route('auth.ofertas.show', $oferta) }}"
                            class="mt-5 inline-flex items-center gap-2 text-xs font-bold text-[#8AFD5D] transition hover:text-white"
                        >
                            Ver oferta completa
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0-5 5m5-5H6" />
                            </svg>
                        </a>

                    </article>

                @empty

                    <div class="col-span-full flex min-h-[220px] items-center justify-center">

                        <div class="w-full max-w-md rounded-3xl border border-white/10 bg-[#0A2A3F]/50 p-10 text-center">

                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/5">

                                <svg class="h-8 w-8 text-[#8AFD5D]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H3a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    />

                                </svg>

                            </div>


                            <p class="mt-5 text-base font-semibold text-white">
                                No hay ofertas disponibles
                            </p>

                            <p class="mt-2 text-sm text-slate-400">
                                Actualmente no hay ofertas de formación para mostrar.
                            </p>

                        </div>

                    </div>

                @endforelse

            </div>


            <div class="mt-8 text-center md:hidden">

                <a
                    href="{{ route('auth.ofertas') }}"
                    class="inline-flex rounded-xl border border-[#8AFD5D]/30 bg-[#8AFD5D]/10 px-5 py-3 text-sm font-bold text-[#8AFD5D]"
                >
                    Ver todas las ofertas
                </a>

            </div>

        </div>

    </section>


    <section id="mision-vision" class="bg-[#001E30] py-20">

        <div class="mx-auto max-w-7xl px-6 lg:px-8">

            <div class="mb-12 text-center">

                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#8AFD5D]">
                    Nuestra identidad
                </p>

                <h2 class="mt-3 text-3xl font-black uppercase tracking-tight text-white">
                    Misión y visión
                </h2>

            </div>


            <div class="grid gap-8 md:grid-cols-2">

                <div class="relative rounded-[28px] border border-white/10 bg-[#0A2A3F]/60 p-8 shadow-xl shadow-[#000]/20">

                    <div class="absolute -top-5 left-8 inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-[#8AFD5D]/30 bg-[#001E30] text-[#8AFD5D]">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7"
                            />
                        </svg>

                    </div>


                    <h3 class="mt-6 text-xl font-black uppercase tracking-wide text-white">
                        Misión del SENA
                    </h3>

                    <p class="mt-4 text-sm leading-relaxed text-slate-300">
                        El SENA impulsa el desarrollo social y técnico de los trabajadores colombianos mediante la formación profesional integral,
                        la innovación y la articulación con el sector productivo para fortalecer la productividad y la equidad del país.
                    </p>

                </div>


                <div class="relative rounded-[28px] border border-white/10 bg-[#0A2A3F]/60 p-8 shadow-xl shadow-[#000]/20">

                    <div class="absolute -top-5 left-8 inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-[#8AFD5D]/30 bg-[#001E30] text-[#8AFD5D]">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm-9.5 7.5A9 9 0 1118.5 4.5a9 9 0 01-12 15z"
                            />
                        </svg>

                    </div>


                    <h3 class="mt-6 text-xl font-black uppercase tracking-wide text-white">
                        Visión del SENA
                    </h3>

                    <p class="mt-4 text-sm leading-relaxed text-slate-300">
                        El SENA será una organización de conocimiento para todos los colombianos, reconocida por su innovación permanente,
                        calidad institucional y capacidad para transformar la educación y la productividad nacional.
                    </p>

                </div>

            </div>

        </div>

    </section>

@endsection