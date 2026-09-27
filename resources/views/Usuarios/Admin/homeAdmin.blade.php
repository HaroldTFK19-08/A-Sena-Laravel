@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Home Admin')

@section('contenido')
    @php
        $fechaActual = now()->translatedFormat('d \d\e F \d\e Y');
    @endphp

    <div class="space-y-8">
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 md:p-8 shadow-[0_20px_45px_rgba(15,40,53,0.08)]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>
            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Dashboard</p>
                    <h1 class="mt-3 text-3xl md:text-4xl font-black text-[#0A2334] leading-tight">
                        Hola, {{ $nombre_1 ?? 'Administrador' }}
                    </h1>
                    <p class="mt-3 max-w-2xl text-sm md:text-base text-[#3b5d6e] leading-relaxed">
                        Aquí tienes un resumen general del estado del sistema, la actividad institucional y los accesos principales del administrador.
                    </p>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#4b6473]">Total Centros</p>
                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 20V7.5A2.5 2.5 0 016.5 5h11A2.5 2.5 0 0120 7.5V20M8 10h8m-8 4h8M8 18h8"/></svg>
                    </span>
                </div>
                <p class="mt-5 text-3xl font-black text-[#0A2334]">{{ $totalCentros ?? 0 }}</p>
                <p class="mt-2 text-xs text-[#5F7785]">Centros registrados en el sistema</p>
            </div>

            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#4b6473]">Total Aprendices</p>
                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-8 9a4 4 0 014-4h4a4 4 0 014 4v1H8v-1z"/></svg>
                    </span>
                </div>
                <p class="mt-5 text-3xl font-black text-[#0A2334]">{{ $totalAprendices ?? 0 }}</p>
                <p class="mt-2 text-xs text-[#5F7785]">Aprendices activos en la plataforma</p>
            </div>

            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#4b6473]">Módulos activos</p>
                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 8l8-4 8 4-8 4-8-4zm0 8l8 4 8-4M4 12l8 4 8-4"/></svg>
                    </span>
                </div>
                <p class="mt-5 text-3xl font-black text-[#0A2334]">07</p>
                <p class="mt-2 text-xs text-[#5F7785]">Módulos del sistema disponibles</p>
            </div>

            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#4b6473]">Estado del sistema</p>
                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12.5l3 3L19 1.5m0 11l-3 3-7-7"/></svg>
                    </span>
                </div>
                <p class="mt-5 text-3xl font-black text-[#0E6B54]">100%</p>
                <p class="mt-2 text-xs text-[#5F7785]">Servicios operando correctamente</p>
            </div>
        </section>

        <section class="grid grid-cols-1 xl:grid-cols-[1.7fr_1fr] gap-6">
            <div class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Accesos rápidos</p>
                        <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Gestión institucional</h2>
                    </div>
                    <span class="text-xs text-[#0E6B54] font-semibold">Hoy · {{ $fechaActual }}</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('centros.index') }}" class="group rounded-2xl border border-[#D8E6EB] bg-white p-4 transition-all hover:-translate-y-0.5 hover:border-[#8AFD5D]/50 hover:bg-[#F4FFF1] shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#D8F7CB] text-[#0E6B54]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6.75A2.75 2.75 0 016.75 4h10.5A2.75 2.75 0 0120 6.75v10.5A2.75 2.75 0 0117.25 20H6.75A2.75 2.75 0 014 17.25V6.75zm4.75 0v10.5m10.5-10.5v10.5"/></svg>
                            </span>
                            <span class="text-xs font-semibold text-[#4b6473] group-hover:text-[#0E6B54]">Centros</span>
                        </div>
                        <p class="mt-4 text-lg font-bold text-[#0A2334]">Administrar centros</p>
                        <p class="mt-1 text-sm text-[#5F7785]">Gestión de sedes, ubicaciones y configuración institucional.</p>
                    </a>

                    <a href="{{ route('areas.index') }}" class="group rounded-2xl border border-[#D8E6EB] bg-white p-4 transition-all hover:-translate-y-0.5 hover:border-[#8AFD5D]/50 hover:bg-[#F4FFF1] shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#D8F7CB] text-[#0E6B54]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-8 9a4 4 0 014-4h4a4 4 0 014 4v1H8v-1z"/></svg>
                            </span>
                            <span class="text-xs font-semibold text-[#4b6473] group-hover:text-[#0E6B54]">Áreas</span>
                        </div>
                        <p class="mt-4 text-lg font-bold text-[#0A2334]">Áreas académicas</p>
                        <p class="mt-1 text-sm text-[#5F7785]">Organiza las áreas vinculadas a cada centro.</p>
                    </a>

                    <a href="{{ route('ambientes.index') }}" class="group rounded-2xl border border-[#D8E6EB] bg-white p-4 transition-all hover:-translate-y-0.5 hover:border-[#8AFD5D]/50 hover:bg-[#F4FFF1] shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#D8F7CB] text-[#0E6B54]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 19.5V5.5A2.5 2.5 0 016.5 3h11A2.5 2.5 0 0120 5.5v14M7 7h10M7 11h10M7 15h6"/></svg>
                            </span>
                            <span class="text-xs font-semibold text-[#4b6473] group-hover:text-[#0E6B54]">Ambientes</span>
                        </div>
                        <p class="mt-4 text-lg font-bold text-[#0A2334]">Ambientes de formación</p>
                        <p class="mt-1 text-sm text-[#5F7785]">Administra capacidad, tipo y centro asignado.</p>
                    </a>

                    <a href="{{ route('equipos.index') }}" class="group rounded-2xl border border-[#D8E6EB] bg-white p-4 transition-all hover:-translate-y-0.5 hover:border-[#8AFD5D]/50 hover:bg-[#F4FFF1] shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#D8F7CB] text-[#0E6B54]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6l4 2m4-8a10 10 0 11-20 0 10 10 0 0120 0z"/></svg>
                            </span>
                            <span class="text-xs font-semibold text-[#4b6473] group-hover:text-[#0E6B54]">Equipos</span>
                        </div>
                        <p class="mt-4 text-lg font-bold text-[#0A2334]">Inventario de equipos</p>
                        <p class="mt-1 text-sm text-[#5F7785]">Consulta y administra equipos por ambiente.</p>
                    </a>
                </div>
            </div>

            <div class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Resumen</p>
                <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Indicadores clave</h2>

                <div class="mt-6 space-y-5">
                    <div>
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-[#456073]">Cobertura</span>
                            <span class="font-semibold text-[#0E6B54]">86%</span>
                        </div>
                        <div class="h-2.5 rounded-full bg-[#DDEAF0] overflow-hidden">
                            <div class="h-full w-[86%] rounded-full bg-[#8AFD5D]"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-[#456073]">Asignaciones</span>
                            <span class="font-semibold text-[#0E6B54]">72%</span>
                        </div>
                        <div class="h-2.5 rounded-full bg-[#DDEAF0] overflow-hidden">
                            <div class="h-full w-[72%] rounded-full bg-[#8AFD5D]"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-[#456073]">Procesos completados</span>
                            <span class="font-semibold text-[#0E6B54]">94%</span>
                        </div>
                        <div class="h-2.5 rounded-full bg-[#DDEAF0] overflow-hidden">
                            <div class="h-full w-[94%] rounded-full bg-[#8AFD5D]"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 rounded-2xl border border-[#CBE4D5] bg-[#EAFBF0] p-4">
                    <p class="text-xs uppercase tracking-[0.24em] text-[#0E6B54]">Última actualización</p>
                    <p class="mt-2 text-sm text-[#466371]">Los datos se sincronizan de forma automática cada 15 minutos.</p>
                </div>
            </div>
        </section>
    </div>
@endsection
