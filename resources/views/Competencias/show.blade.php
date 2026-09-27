@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Detalle de competencia')

@section('contenido')
    <div class="space-y-8">

        {{-- HERO --}}
        <section
            class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.08)] md:p-8">

            <div
                class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]">
            </div>

            <div class="relative flex flex-col gap-6 md:flex-row md:items-center md:justify-between">

                <div>
                    <span class="text-sm font-semibold uppercase tracking-[0.18em] text-[#1B5E6A]">
                        Gestión académica
                    </span>

                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#0A2334] md:text-4xl">
                        {{ $competencia->nombre }}
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-6 text-[#3B5D6E] md:text-base">
                        Información detallada de la competencia académica registrada en el sistema.
                    </p>
                </div>

                <a href="{{ route('competencias.index') }}"
                    class="inline-flex w-fit items-center gap-2 rounded-xl border border-[#D8E6EB] bg-white/80 px-4 py-2.5 text-sm font-semibold text-[#45616F] shadow-sm backdrop-blur-sm transition hover:border-[#8AFD5D] hover:bg-white hover:text-[#234657]">

                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 19l-7-7 7-7" />
                    </svg>

                    Competencias
                </a>

            </div>
        </section>


        {{-- INFORMACIÓN --}}
        <section
            class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.06)] md:p-8">

            <div class="mb-8 flex items-center gap-4">

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#EAFBF0] text-[#39A900]">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5 2a8 8 0 1 1-16 0 8 8 0 0 1 16 0z" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-[#0A2334]">
                        Información de la competencia
                    </h2>

                    <p class="text-sm text-[#6B8490]">
                        Datos registrados para esta competencia.
                    </p>
                </div>

            </div>


            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- CÓDIGO --}}
                <div class="rounded-2xl border border-[#D8E6EB] bg-white p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#78909C]">
                        Código
                    </p>

                    <p class="mt-2 text-base font-semibold text-[#0A2334]">
                        {{ $competencia->codigo ?: 'Sin código' }}
                    </p>
                </div>


                {{-- INSTRUCTOR --}}
                <div class="rounded-2xl border border-[#D8E6EB] bg-white p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#78909C]">
                        Instructor
                    </p>

                    <p class="mt-2 text-base font-semibold text-[#0A2334]">
                        {{ trim(($competencia->teacher?->user?->nombre_1 ?? '') . ' ' . ($competencia->teacher?->user?->apellido_1 ?? '')) ?: 'Sin asignar' }}
                    </p>
                </div>


                {{-- FECHA INICIO --}}
                <div class="rounded-2xl border border-[#D8E6EB] bg-white p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#78909C]">
                        Fecha de inicio
                    </p>

                    <p class="mt-2 text-base font-semibold text-[#0A2334]">
                        {{ $competencia->fecha_inicio ?: 'Sin fecha' }}
                    </p>
                </div>


                {{-- FECHA FIN --}}
                <div class="rounded-2xl border border-[#D8E6EB] bg-white p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#78909C]">
                        Fecha de finalización
                    </p>

                    <p class="mt-2 text-base font-semibold text-[#0A2334]">
                        {{ $competencia->fecha_fin ?: 'Sin fecha' }}
                    </p>
                </div>


                {{-- DESCRIPCIÓN --}}
                <div class="md:col-span-2 rounded-2xl border border-[#D8E6EB] bg-white p-5">

                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#78909C]">
                        Descripción
                    </p>

                    <p class="mt-3 text-sm leading-7 text-[#45616F]">
                        {{ $competencia->descripcion ?: 'Esta competencia no tiene una descripción registrada.' }}
                    </p>

                </div>

            </div>


            {{-- ACCIONES --}}
            <div class="mt-8 flex flex-col-reverse gap-3 border-t border-[#D8E6EB] pt-6 sm:flex-row sm:justify-end">

                <a href="{{ route('competencias.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-[#C7D8DE] bg-white px-6 py-3 text-sm font-semibold text-[#45616F] transition hover:border-[#9BAEB7] hover:bg-[#F4F7F2]">
                    Cancelar
                </a>

                <a href="{{ route('competencias.edit', $competencia) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#8AFD5D] px-6 py-3 text-sm font-bold text-[#001E30] shadow-[0_8px_20px_rgba(138,253,93,0.25)] transition hover:bg-[#76E94C] hover:shadow-[0_10px_24px_rgba(138,253,93,0.35)]">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-8.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 7.5-7.5z" />
                    </svg>

                    Editar competencia
                </a>

            </div>

        </section>

    </div>
@endsection
