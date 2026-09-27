@extends('Layouts.Auth.AppInicio')

@section('titulo', $noticia->titulo)

@section('contenido')

<section class="bg-[#081B28] py-12 md:py-20">

    <div class="mx-auto max-w-5xl px-6 lg:px-8">

        <a
            href="{{ route('auth.noticias') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-[#8AFD5D] transition hover:text-white"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7 7-7-7 7-7" />
            </svg>
            Volver a noticias
        </a>

        <article class="mt-8 overflow-hidden rounded-[32px] border border-white/10 bg-[#0A2A3F]/70">

            @if ($noticia->imagen)
                <img
                    src="{{ asset('storage/' . $noticia->imagen) }}"
                    alt="{{ $noticia->titulo }}"
                    class="h-72 w-full object-cover md:h-96"
                >
            @else
                <div class="flex h-72 items-center justify-center bg-[#001E30] md:h-96">
                    <svg class="h-24 w-24 text-[#8AFD5D]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v12a2 2 0 01-2 2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 11l2.5 2.5L14 10l4 4" />
                    </svg>
                </div>
            @endif

            <div class="p-6 md:p-10">

                <div class="flex flex-wrap items-center gap-3">
                    <span class="rounded-full bg-[#8AFD5D]/10 px-3 py-1.5 text-[10px] font-bold uppercase tracking-[0.2em] text-[#8AFD5D]">
                        {{ $noticia->categoria ?? 'Institucional' }}
                    </span>
                    @if ($noticia->created_at)
                        <span class="text-xs text-slate-400">
                            {{ $noticia->created_at->format('d/m/Y') }}
                        </span>
                    @endif
                </div>

                <h1 class="mt-5 text-3xl font-black leading-tight text-white md:text-5xl">
                    {{ $noticia->titulo }}
                </h1>

                @if ($noticia->trainingcenter)
                    <p class="mt-4 text-sm font-semibold text-slate-400">
                        {{ $noticia->trainingcenter->nombre }}
                    </p>
                @endif

                <div class="mt-8 border-t border-white/10 pt-8 text-base leading-8 text-slate-300">
                    {!! nl2br(e($noticia->descripcion)) !!}
                </div>

                <div class="mt-10 border-t border-white/10 pt-6">
                    <a
                        href="{{ route('auth.noticias') }}"
                        class="inline-flex items-center gap-2 rounded-xl border border-white/15 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/5"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7 7-7-7 7-7" />
                        </svg>
                        Volver a todas las noticias
                    </a>
                </div>

            </div>

        </article>

    </div>

</section>

@endsection
