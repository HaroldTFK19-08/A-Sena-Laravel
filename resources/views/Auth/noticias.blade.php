@extends('Layouts.Auth.AppInicio')

@section('contenido')

<section class="bg-[#081B28] py-16 md:py-20">

    <div class="mx-auto max-w-7xl px-6 lg:px-8">

        <div class="mb-12 text-center">

            <span class="inline-flex rounded-full border border-[#8AFD5D]/20 bg-[#8AFD5D]/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-[#8AFD5D]">
                Actualidad institucional
            </span>

            <h1 class="mt-5 text-4xl font-black tracking-tight text-white md:text-5xl">
                Noticias
            </h1>

            <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-slate-400 md:text-base">
                Consulta las últimas noticias, novedades y acontecimientos publicados por el SENA.
            </p>

        </div>


        {{-- FILTROS --}}

        <div class="mb-12 rounded-3xl border border-white/10 bg-[#0A2A3F]/70 p-5 shadow-xl">

            <form
                action="{{ route('auth.noticias.buscar') }}"
                method="GET"
                class="grid gap-4 md:grid-cols-[1fr_220px_auto]"
            >

                <div class="relative">

                    <svg
                        class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-500"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"
                        />
                    </svg>

                    <input
                        type="text"
                        name="titulo"
                        value="{{ request('titulo') }}"
                        placeholder="Buscar por título..."
                        class="w-full rounded-2xl border border-white/10 bg-[#081B28] py-3.5 pl-12 pr-4 text-sm text-white outline-none transition placeholder:text-slate-500 focus:border-[#8AFD5D]/50 focus:ring-2 focus:ring-[#8AFD5D]/10"
                    >

                </div>


                <select
                    name="categoria"
                    class="rounded-2xl border border-white/10 bg-[#081B28] px-4 py-3.5 text-sm text-white outline-none transition focus:border-[#8AFD5D]/50 focus:ring-2 focus:ring-[#8AFD5D]/10"
                >

                    <option value="">
                        Todas las categorías
                    </option>

                    @foreach ($noticias->pluck('categoria')->filter()->unique()->sort() as $categoria)

                        <option
                            value="{{ $categoria }}"
                            {{ request('categoria') == $categoria ? 'selected' : '' }}
                        >
                            {{ $categoria }}
                        </option>

                    @endforeach

                </select>


                <button
                    type="submit"
                    class="rounded-2xl bg-[#39A900] px-6 py-3.5 text-sm font-bold text-white transition hover:bg-[#2f8f00] active:scale-[0.98]"
                >
                    Buscar
                </button>

            </form>

        </div>


        {{-- ENCABEZADO DE RESULTADOS --}}

        <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8AFD5D]">
                    Publicaciones
                </p>

                <h2 class="mt-2 text-2xl font-black text-white md:text-3xl">
                    Todas las noticias
                </h2>

            </div>

            <span class="w-fit rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold text-slate-400">
                {{ $noticias->count() }}
                {{ $noticias->count() === 1 ? 'noticia encontrada' : 'noticias encontradas' }}
            </span>

        </div>


        {{-- NOTICIAS --}}

        <div class="grid gap-7 md:grid-cols-2 xl:grid-cols-3">

            @forelse ($noticias as $noticia)

                <article class="group overflow-hidden rounded-[28px] border border-white/10 bg-[#0A2A3F]/70 shadow-lg transition duration-300 hover:-translate-y-1 hover:border-[#8AFD5D]/30 hover:shadow-2xl">

                    {{-- IMAGEN --}}

                    @if ($noticia->imagen)

                        <div class="relative h-56 overflow-hidden">

                            <img
                                src="{{ asset('storage/' . $noticia->imagen) }}"
                                alt="{{ $noticia->titulo }}"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                            >

                            <div class="absolute inset-0 bg-gradient-to-t from-[#081B28] via-transparent to-transparent"></div>

                        </div>

                    @else

                        <div class="flex h-56 items-center justify-center bg-gradient-to-br from-[#0A2A3F] to-[#001E30]">

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
                                    d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2Z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="m8 11 2.5 2.5L14 10l4 4"
                                />
                            </svg>

                        </div>

                    @endif


                    {{-- CONTENIDO --}}

                    <div class="p-6">

                        <div class="flex items-center justify-between gap-3">

                            @if ($noticia->categoria)

                                <span class="rounded-full bg-[#8AFD5D]/10 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-[#8AFD5D]">
                                    {{ $noticia->categoria }}
                                </span>

                            @else

                                <span class="rounded-full bg-white/5 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                                    Institucional
                                </span>

                            @endif


                            @if ($noticia->created_at)

                                <span class="text-xs text-slate-500">
                                    {{ $noticia->created_at->format('d/m/Y') }}
                                </span>

                            @endif

                        </div>


                        <h3 class="mt-5 line-clamp-2 text-xl font-bold leading-snug text-white transition group-hover:text-[#8AFD5D]">
                            <a href="{{ route('auth.noticias.show', $noticia) }}">{{ $noticia->titulo }}</a>
                        </h3>


                        @if ($noticia->descripcion)

                            <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-400">
                                {{ $noticia->descripcion }}
                            </p>

                        @endif


                        <a href="{{ route('auth.noticias.show', $noticia) }}" class="mt-6 flex items-center gap-2 text-xs font-semibold text-[#8AFD5D]">

                            <span>
                                Leer noticia
                            </span>

                            <svg
                                class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 7l5 5m0 0-5 5m5-5H6"
                                />
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
                                    d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2Z"
                                />
                            </svg>

                        </div>

                        <h3 class="mt-6 text-lg font-bold text-white">
                            No hay noticias disponibles
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-400">
                            No encontramos noticias que coincidan con los criterios de búsqueda.
                        </p>

                    </div>

                </div>

            @endforelse

        </div>

    </div>

</section>

@endsection