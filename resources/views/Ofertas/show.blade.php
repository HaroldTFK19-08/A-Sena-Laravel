@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Detalle de oferta')

@section('contenido')

    <div class="space-y-8">

        {{-- ENCABEZADO --}}
        <section
            class="rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 md:p-8"
        >

            <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">

                <div>

                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">
                        Vista previa
                    </p>

                    <h1 class="mt-3 text-3xl font-black text-[#0A2334]">
                        {{ $oferta->program?->nombre ?? 'Oferta de formación' }}
                    </h1>


                    <div class="mt-4 flex flex-wrap gap-2">

                        {{-- ESTADO GENERAL --}}
                        <span
                            class="rounded-full bg-[#D8F7CB] px-3 py-1 text-xs font-bold text-[#0E6B54]"
                        >
                            {{ $oferta->estado ?? 'En proceso' }}
                        </span>


                        {{-- ESTADO DE PUBLICACIÓN --}}
                        @if ($oferta->publicada)

                            <span
                                class="rounded-full bg-[#DCFCE7] px-3 py-1 text-xs font-bold text-[#166534]"
                            >
                                Publicada
                            </span>

                        @else

                            <span
                                class="rounded-full bg-[#FEF3C7] px-3 py-1 text-xs font-bold text-[#92400E]"
                            >
                                Borrador
                            </span>

                        @endif

                    </div>

                </div>


                {{-- BOTÓN PUBLICAR / DESPUBLICAR --}}
                <div class="shrink-0">

                    @if ($oferta->publicada)

                        {{-- DESPUBLICAR --}}
                        <form
                            action="{{ route('ofertas.despublicar', $oferta) }}"
                            method="POST"
                        >

                            @csrf

                            @method('PATCH')

                            <button
                                type="submit"
                                onclick="return confirm('¿Deseas retirar esta oferta de publicación?');"
                                class="inline-flex items-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-5 py-3 text-sm font-extrabold text-amber-700 shadow-sm transition hover:bg-amber-100"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m3.09-2.66A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.958 9.958 0 01-4.132 5.411M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 6L6 6"
                                    />
                                </svg>

                                Despublicar

                            </button>

                        </form>

                    @else

                        {{-- PUBLICAR --}}
                        <form
                            action="{{ route('ofertas.publicar', $oferta) }}"
                            method="POST"
                        >

                            @csrf

                            @method('PATCH')

                            <button
                                type="submit"
                                onclick="return confirm('¿Deseas publicar esta oferta?');"
                                class="inline-flex items-center gap-2 rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30] shadow-sm transition hover:bg-[#72E84D]"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 12h14M12 5l7 7-7 7"
                                    />
                                </svg>

                                Publicar oferta

                            </button>

                        </form>

                    @endif

                </div>

            </div>

        </section>


        {{-- INFORMACIÓN DE LA OFERTA --}}
        <section
            class="rounded-[30px] border border-[#D8E6EB] bg-white p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)] md:p-8"
        >

            {{-- IMAGEN --}}
            @if ($oferta->imagen)

                <img
                    src="{{ asset('storage/' . $oferta->imagen) }}"
                    alt="{{ $oferta->program?->nombre ?? 'Oferta de formación' }}"
                    class="mb-6 max-h-80 w-full rounded-2xl object-cover"
                >

            @endif


            {{-- DATOS --}}
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                {{-- CAPACIDAD --}}
                <div
                    class="rounded-xl border border-[#D8E6EB] bg-[#F7FBFC] p-4"
                >

                    <p class="text-xs font-bold uppercase tracking-wider text-[#78909C]">
                        Capacidad
                    </p>

                    <p class="mt-2 font-bold text-[#0A2334]">
                        {{ $oferta->capacidad ?: 'No registrado' }}
                    </p>

                </div>


                {{-- LANZAMIENTO --}}
                <div
                    class="rounded-xl border border-[#D8E6EB] bg-[#F7FBFC] p-4"
                >

                    <p class="text-xs font-bold uppercase tracking-wider text-[#78909C]">
                        Lanzamiento
                    </p>

                    <p class="mt-2 font-bold text-[#0A2334]">
                        {{ $oferta->fecha_lanzamiento?->format('d/m/Y') ?? 'No registrado' }}
                    </p>

                </div>


                {{-- CONVOCATORIA --}}
                <div
                    class="rounded-xl border border-[#D8E6EB] bg-[#F7FBFC] p-4"
                >

                    <p class="text-xs font-bold uppercase tracking-wider text-[#78909C]">
                        Convocatoria
                    </p>

                    <p class="mt-2 font-bold text-[#0A2334]">
                        {{ $oferta->fecha_convocatoria?->format('d/m/Y') ?? 'No registrado' }}
                    </p>

                </div>


                {{-- CIERRE --}}
                <div
                    class="rounded-xl border border-[#D8E6EB] bg-[#F7FBFC] p-4"
                >

                    <p class="text-xs font-bold uppercase tracking-wider text-[#78909C]">
                        Cierre
                    </p>

                    <p class="mt-2 font-bold text-[#0A2334]">
                        {{ $oferta->fecha_fin_convocatoria?->format('d/m/Y') ?? 'No registrado' }}
                    </p>

                </div>


                {{-- PRIMERA PRUEBA --}}
                <div
                    class="rounded-xl border border-[#D8E6EB] bg-[#F7FBFC] p-4"
                >

                    <p class="text-xs font-bold uppercase tracking-wider text-[#78909C]">
                        Primera prueba
                    </p>

                    <p class="mt-2 font-bold text-[#0A2334]">
                        {{ $oferta->fecha_primera_prueba?->format('d/m/Y') ?? 'No registrado' }}
                    </p>

                </div>


                {{-- SEGUNDA PRUEBA --}}
                <div
                    class="rounded-xl border border-[#D8E6EB] bg-[#F7FBFC] p-4"
                >

                    <p class="text-xs font-bold uppercase tracking-wider text-[#78909C]">
                        Segunda prueba
                    </p>

                    <p class="mt-2 font-bold text-[#0A2334]">
                        {{ $oferta->fecha_segunda_prueba?->format('d/m/Y') ?? 'No registrado' }}
                    </p>

                </div>


                {{-- SELECCIONADOS --}}
                <div
                    class="rounded-xl border border-[#D8E6EB] bg-[#F7FBFC] p-4"
                >

                    <p class="text-xs font-bold uppercase tracking-wider text-[#78909C]">
                        Seleccionados
                    </p>

                    <p class="mt-2 font-bold text-[#0A2334]">
                        {{ $oferta->fecha_seleccionados?->format('d/m/Y') ?? 'No registrado' }}
                    </p>

                </div>

            </div>


            {{-- ACCIONES --}}
            <div class="mt-6 flex flex-wrap gap-3">

                {{-- EDITAR --}}
                <a
                    href="{{ route('ofertas.edit', $oferta) }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30] transition hover:bg-[#72E84D]"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11 5h2m-1 0v14m-7-7h14"
                        />
                    </svg>

                    Editar oferta

                </a>


                {{-- VOLVER --}}
                <a
                    href="{{ route('ofertas.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-[#C7DCE2] bg-white px-5 py-3 text-sm font-semibold text-[#0A2334] transition hover:bg-[#F7FBFC]"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>

                    Volver

                </a>

            </div>

        </section>

    </div>

@endsection