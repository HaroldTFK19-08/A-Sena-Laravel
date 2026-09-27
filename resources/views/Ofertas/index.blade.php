
@extends('Layouts.Usuarios.AppAdmin')
@section('titulo', 'Ofertas de formación')
@section('contenido')
    <div class="space-y-8">

        <section
            class="rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.08)] md:p-8">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">
                        Gestión académica
                    </p>

                    <h1 class="mt-3 text-3xl font-black text-[#0A2334] md:text-4xl">
                        Ofertas de formación
                    </h1>

                    <p class="mt-3 text-sm text-[#3B5D6E] md:text-base">
                        Administra las convocatorias disponibles para los programas de formación.
                    </p>
                </div>

                <a
                    href="{{ route('ofertas.create') }}"
                    class="inline-flex justify-center rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30] transition hover:bg-[#75e94c]"
                >
                    Nueva oferta
                </a>

            </div>

        </section>


        @if (session('success'))

            <div class="rounded-2xl border border-[#BFE6B1] bg-[#EAFBF0] p-4 text-sm font-semibold text-[#0E6B54]">
                {{ session('success') }}
            </div>

        @endif


        <section
            class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">

            <div class="mb-6 flex items-end justify-between">

                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">
                        Listado
                    </p>

                    <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">
                        Convocatorias registradas
                    </h2>
                </div>

                <span class="text-sm text-[#78909C]">
                    {{ $ofertas->count() }}
                    {{ $ofertas->count() === 1 ? 'oferta' : 'ofertas' }}
                </span>

            </div>


            @if ($ofertas->isEmpty())

                <div class="rounded-2xl border border-dashed border-[#D8E6EB] bg-white p-10 text-center">

                    <p class="text-sm font-semibold text-[#5F7785]">
                        Aún no hay ofertas registradas.
                    </p>

                    <a
                        href="{{ route('ofertas.create') }}"
                        class="mt-4 inline-flex rounded-xl bg-[#8AFD5D] px-5 py-2.5 text-sm font-extrabold text-[#001E30]"
                    >
                        Crear la primera oferta
                    </a>

                </div>

            @else

                <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">

                    @foreach ($ofertas as $oferta)

                        <article
                            class="overflow-hidden rounded-2xl border border-[#D8E6EB] bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                            @if ($oferta->imagen)

                                <div class="relative">

                                    <img
                                        src="{{ asset('storage/' . $oferta->imagen) }}"
                                        alt="{{ $oferta->program?->nombre }}"
                                        class="h-40 w-full object-cover"
                                    >

                                    @if ($oferta->publicada)

                                        <span
                                            class="absolute right-3 top-3 rounded-full bg-[#EAFBF0] px-2 py-1 text-[10px] font-bold uppercase text-[#0E6B54] shadow-sm"
                                        >
                                            Publicada
                                        </span>

                                    @else

                                        <span
                                            class="absolute right-3 top-3 rounded-full bg-white/90 px-2 py-1 text-[10px] font-bold uppercase text-[#78909C] shadow-sm"
                                        >
                                            Borrador
                                        </span>

                                    @endif

                                </div>

                            @else

                                <div
                                    class="relative flex h-40 items-center justify-center bg-[#EAF6F4] text-4xl font-black text-[#0E6B54]"
                                >

                                    {{ strtoupper(substr($oferta->program?->nombre ?? 'O', 0, 1)) }}

                                    @if ($oferta->publicada)

                                        <span
                                            class="absolute right-3 top-3 rounded-full bg-[#EAFBF0] px-2 py-1 text-[10px] font-bold uppercase text-[#0E6B54]"
                                        >
                                            Publicada
                                        </span>

                                    @else

                                        <span
                                            class="absolute right-3 top-3 rounded-full bg-white/90 px-2 py-1 text-[10px] font-bold uppercase text-[#78909C] shadow-sm"
                                        >
                                            Borrador
                                        </span>

                                    @endif

                                </div>

                            @endif


                            <div class="p-4">

                                <div class="flex items-start justify-between gap-3">

                                    <h3 class="line-clamp-2 text-lg font-extrabold text-[#0A2334]">
                                        {{ $oferta->program?->nombre ?? 'Programa no asignado' }}
                                    </h3>

                                </div>


                                <p class="mt-3 text-sm text-[#5F7785]">
                                    Capacidad:
                                    <strong>{{ $oferta->capacidad }}</strong>
                                </p>


                                <div class="mt-4 flex items-center justify-between border-t border-[#EAF1F3] pt-4">

                                    <a
                                        href="{{ route('ofertas.show', $oferta) }}"
                                        class="rounded-lg bg-[#EAF6F4] px-3 py-2 text-xs font-bold text-[#0E6B54]"
                                    >
                                        Vista previa
                                    </a>


                                    <div class="flex gap-1">

                                        <a
                                            href="{{ route('ofertas.edit', $oferta) }}"
                                            title="Editar"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#D8E6EB] text-[#1B5E6A] transition hover:bg-[#EAF6F4]"
                                        >
                                            ✎
                                        </a>


                                        @if (!$oferta->publicada)

                                            <form
                                                action="{{ route('ofertas.publicar', $oferta) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    title="Publicar"
                                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#BFE6B1] bg-[#EAFBF0] text-[#0E6B54] transition hover:bg-[#D9F5E0]"
                                                >
                                                    ✓
                                                </button>

                                            </form>

                                        @else

                                            <form
                                                action="{{ route('ofertas.despublicar', $oferta) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    title="Despublicar"
                                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-amber-200 bg-amber-50 text-amber-600 transition hover:bg-amber-100"
                                                >
                                                    −
                                                </button>

                                            </form>

                                        @endif


                                        <form
                                            action="{{ route('ofertas.destroy', $oferta) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Eliminar esta oferta?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                title="Eliminar"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-rose-200 text-rose-500 transition hover:bg-rose-50"
                                            >
                                                ×
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>

            @endif

        </section>

    </div>

@endsection

