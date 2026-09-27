@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Dashboard Aspirante')

@section('contenido')
    <div class="space-y-8">
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#EAF5F4] via-[#F1F8F7] to-[#E9F0F7] p-6 md:p-8 shadow-[0_20px_45px_rgba(15,40,53,0.08)]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>
            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Dashboard</p>
                    <h1 class="mt-3 text-3xl md:text-4xl font-black text-[#0A2334] leading-tight">
                        Hola, {{ $nombre_1 }}
                    </h1>
                    <p class="mt-3 max-w-2xl text-sm md:text-base text-[#3b5d6e] leading-relaxed">
                        Consulta el estado de tu proceso de inscripción, documentos y próximos pasos para continuar con tu admisión.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('aspirante.inscripciones.index') }}" class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30] shadow-lg shadow-[#8AFD5D]/20 transition-transform hover:-translate-y-0.5">
                        Ver proceso
                    </a>
                    <a href="{{ route('aspirante.ofertas.index') }}" class="inline-flex items-center justify-center rounded-xl border border-[#C7DCE2] bg-white/70 px-5 py-3 text-sm font-semibold text-[#0A2334] transition-colors hover:bg-white">
                        Ver ofertas
                    </a>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#4b6473]">Inscripciones</p>
                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h10v10H7zM9 10h6M9 14h6"/></svg>
                    </span>
                </div>
                <p class="mt-5 text-3xl font-black text-[#0A2334]">{{ $totalInscripciones }}</p>
                <p class="mt-2 text-xs text-[#5F7785]">Inscripciones activas</p>
            </div>

            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#4b6473]">Documentos</p>
                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h10v10H7zM9 10h6M9 14h4"/></svg>
                    </span>
                </div>
                <p class="mt-5 text-3xl font-black text-[#0A2334]">{{ $documentosCompletos }}/4</p>
                <p class="mt-2 text-xs text-[#5F7785]">Documentos cargados</p>
            </div>

            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#4b6473]">Estado</p>
                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12.5l3 3L19 1.5m0 11l-3 3-7-7"/></svg>
                    </span>
                </div>
                <p class="mt-5 text-xl font-black text-[#0E6B54]">{{ $estadoProceso }}</p>
                <p class="mt-2 text-xs text-[#5F7785]">Estado del proceso de admisión</p>
            </div>

            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#4b6473]">Avance</p>
                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 12h16M12 4v16"/></svg>
                    </span>
                </div>
                <p class="mt-5 text-3xl font-black text-[#0E6B54]">{{ round($avanceDocumentos) }}%</p>
                <p class="mt-2 text-xs text-[#5F7785]">Avance del proceso</p>
            </div>
        </section>

        <section class="grid grid-cols-1 xl:grid-cols-[1.7fr_1fr] gap-6">
            <div class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Accesos rápidos</p>
                        <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Mi proceso</h2>
                    </div>
                    <span class="text-xs text-[#0E6B54] font-semibold">Hoy</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('aspirante.perfil') }}" class="group rounded-2xl border border-[#D8E6EB] bg-white p-4 transition-all hover:border-[#8AFD5D]/50 hover:bg-[#F4FFF1] shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#D8F7CB] text-[#0E6B54]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h10v10H7zM9 10h6M9 14h6"/></svg>
                            </span>
                            <span class="text-xs font-semibold text-[#4b6473]">Documentos</span>
                        </div>
                        <p class="mt-4 text-lg font-bold text-[#0A2334]">Subir documentos</p>
                        <p class="mt-1 text-sm text-[#5F7785]">Carga y revisa tus requisitos de admisión.</p>
                    </a>

                    <a href="{{ route('aspirante.inscripciones.index') }}" class="group rounded-2xl border border-[#D8E6EB] bg-white p-4 transition-all hover:border-[#8AFD5D]/50 hover:bg-[#F4FFF1] shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#D8F7CB] text-[#0E6B54]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h10v10H7zM9 10h6M9 14h6"/></svg>
                            </span>
                            <span class="text-xs font-semibold text-[#4b6473]">Inscripción</span>
                        </div>
                        <p class="mt-4 text-lg font-bold text-[#0A2334]">Seguimiento de inscripción</p>
                        <p class="mt-1 text-sm text-[#5F7785]">Revisa el estado de tu solicitud y próximas etapas.</p>
                    </a>

                    <a href="{{ route('aspirante.resultados.index') }}" class="group rounded-2xl border border-[#D8E6EB] bg-white p-4 transition-all hover:border-[#8AFD5D]/50 hover:bg-[#F4FFF1] shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#D8F7CB] text-[#0E6B54]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 19V5m0 14h16M8 16v-5m4 5V8m4 8v-9"/></svg>
                            </span>
                            <span class="text-xs font-semibold text-[#4b6473]">Resultados</span>
                        </div>
                        <p class="mt-4 text-lg font-bold text-[#0A2334]">Consultar resultados</p>
                        <p class="mt-1 text-sm text-[#5F7785]">Consulta tus evaluaciones y próximos pasos.</p>
                    </a>

                    <a href="{{ route('aspirante.fechas') }}" class="group rounded-2xl border border-[#D8E6EB] bg-white p-4 transition-all hover:border-[#8AFD5D]/50 hover:bg-[#F4FFF1] shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#D8F7CB] text-[#0E6B54]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6l4 2m4-8a10 10 0 11-20 0 10 10 0 0120 0z"/></svg>
                            </span>
                            <span class="text-xs font-semibold text-[#4b6473]">Fechas</span>
                        </div>
                        <p class="mt-4 text-lg font-bold text-[#0A2334]">Cronograma</p>
                        <p class="mt-1 text-sm text-[#5F7785]">Consulta plazos y actividades importantes.</p>
                    </a>
                </div>
            </div>

            <div class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Resumen</p>
                <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Estado general</h2>

                <div class="mt-6 space-y-5">
                    <div>
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-[#456073]">Documentación</span>
                            <span class="font-semibold text-[#0E6B54]">{{ round($avanceDocumentos) }}%</span>
                        </div>
                        <div class="h-2.5 rounded-full bg-[#DDEAF0] overflow-hidden">
                            <div class="h-full rounded-full bg-[#8AFD5D]" style="width: {{ round($avanceDocumentos) }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 rounded-2xl border border-[#CBE4D5] bg-[#EAFBF0] p-4">
                    <p class="text-xs uppercase tracking-[0.24em] text-[#0E6B54]">Siguiente paso</p>
                    <p class="mt-2 text-sm text-[#466371]">Completa la documentación para avanzar en tu proceso de admisión.</p>
                </div>
            </div>
        </section>
    </div>
@endsection
