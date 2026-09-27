@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Dashboard Instructor')

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
                        Aquí puedes supervisar tus fichas, competencias y el desempeño general de tus aprendices en el proceso formativo.
                    </p>
                </div>
            </div>
        </section>
        <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#4b6473]">Aprendices</p>
                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-8 9a4 4 0 014-4h4a4 4 0 014 4v1H8v-1z"/></svg>
                    </span>
                </div>
                <p class="mt-5 text-3xl font-black text-[#0A2334]">{{ $totalAprendices }}</p>
                <p class="mt-2 text-xs text-[#5F7785]">Aprendices registrados</p>
            </div>

            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#4b6473]">Fichas</p>
                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.8" d="M4 20h16M5 20V8.5L12 4l7 4.5V20M9 20v-5h6v5M8 10h.01M12 10h.01M16 10h.01"/></svg>
                    </span>
                </div>
                <p class="mt-5 text-3xl font-black text-[#0A2334]">{{ $fichasAsignadas }}</p>
                <p class="mt-2 text-xs text-[#5F7785]">Fichas asignadas</p>
            </div>

            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#4b6473]">Competencias</p>
                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 2v20M2 12h20"/></svg>
                    </span>
                </div>
                <p class="mt-5 text-3xl font-black text-[#0A2334]">{{ $totalCompetencias }}</p>
                <p class="mt-2 text-xs text-[#5F7785]">Competencias vinculadas</p>
            </div>

            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#4b6473]">Asignaciones</p>
                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6M7 7h10a2 2 0 012 2v8a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z"/></svg>
                    </span>
                </div>
                <p class="mt-5 text-3xl font-black text-[#0E6B54]">{{ $totalAsignaciones }}</p>
                <p class="mt-2 text-xs text-[#5F7785]">Actividades registradas</p>
            </div>
        </section>

        <section class="grid grid-cols-1 xl:grid-cols-[1.7fr_1fr] gap-6">
            <div class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Accesos rápidos</p>
                        <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Gestión docente</h2>
                    </div>
                    <span class="text-xs text-[#0E6B54] font-semibold">Hoy</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('instructor.aprendices') }}" class="group rounded-2xl border border-[#D8E6EB] bg-white p-4 transition-all hover:border-[#8AFD5D]/50 hover:bg-[#F4FFF1] shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#D8F7CB] text-[#0E6B54]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-8 9a4 4 0 014-4h4a4 4 0 014 4v1H8v-1z"/></svg>
                            </span>
                            <span class="text-xs font-semibold text-[#4b6473]">Aprendices</span>
                        </div>
                        <p class="mt-4 text-lg font-bold text-[#0A2334]">Gestionar aprendices</p>
                        <p class="mt-1 text-sm text-[#5F7785]">Consulta y organiza los estudiantes asociados.</p>
                    </a>

                    <a href="{{ route('instructor.fichas') }}" class="group rounded-2xl border border-[#D8E6EB] bg-white p-4 transition-all hover:border-[#8AFD5D]/50 hover:bg-[#F4FFF1] shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#D8F7CB] text-[#0E6B54]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 20h16M5 20V8.5L12 4l7 4.5V20M9 20v-5h6v5M8 10h.01M12 10h.01M16 10h.01"/></svg>
                            </span>
                            <span class="text-xs font-semibold text-[#4b6473]">Fichas</span>
                        </div>
                        <p class="mt-4 text-lg font-bold text-[#0A2334]">Seguimiento de fichas</p>
                        <p class="mt-1 text-sm text-[#5F7785]">Controla grupos, horarios y avances.</p>
                    </a>

                    <a href="{{ route('instructor.resultados.index') }}" class="group rounded-2xl border border-[#D8E6EB] bg-white p-4 transition-all hover:border-[#8AFD5D]/50 hover:bg-[#F4FFF1] shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#D8F7CB] text-[#0E6B54]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 19V5m0 14h16M8 16v-5m4 5V8m4 8v-9"/></svg>
                            </span>
                            <span class="text-xs font-semibold text-[#4b6473]">Reportes</span>
                        </div>
                        <p class="mt-4 text-lg font-bold text-[#0A2334]">Analítica del programa</p>
                        <p class="mt-1 text-sm text-[#5F7785]">Revisa resultados y desarrollo académico.</p>
                    </a>

                    <a href="{{ route('instructor.asignaciones.index') }}" class="group rounded-2xl border border-[#D8E6EB] bg-white p-4 transition-all hover:border-[#8AFD5D]/50 hover:bg-[#F4FFF1] shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#D8F7CB] text-[#0E6B54]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6M7 7h10a2 2 0 012 2v8a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z"/></svg>
                            </span>
                            <span class="text-xs font-semibold text-[#4b6473]">Asignaciones</span>
                        </div>
                        <p class="mt-4 text-lg font-bold text-[#0A2334]">Gestionar asignaciones</p>
                        <p class="mt-1 text-sm text-[#5F7785]">Registra, edita y supervisa equipos entregados a los aprendices.</p>
                    </a>
                </div>
            </div>

            <div class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Resumen</p>
                <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Indicadores clave</h2>

                <div class="mt-6 space-y-5">
                    <div>
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-[#456073]">Cumplimiento</span>
                            <span class="font-semibold text-[#0E6B54]">{{ $progreso }}%</span>
                        </div>
                        <div class="h-2.5 rounded-full bg-[#DDEAF0] overflow-hidden">
                            <div class="h-full rounded-full bg-[#8AFD5D]" style="width: {{ $progreso }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 rounded-2xl border border-[#CBE4D5] bg-[#EAFBF0] p-4">
                    <p class="text-xs uppercase tracking-[0.24em] text-[#0E6B54]">Siguiente paso</p>
                    <p class="mt-2 text-sm text-[#466371]">Revisa el avance de tus grupos para mantener una formación efectiva.</p>
                </div>
            </div>
        </section>

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Tus Fichas</p>
                    <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Fichas Asignadas</h2>
                </div>
            </div>

            @if($fichas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-[#D8E6EB] text-sm text-[#4b6473]">
                                <th class="py-3 px-4 font-semibold">Código</th>
                                <th class="py-3 px-4 font-semibold">Programa</th>
                                <th class="py-3 px-4 font-semibold">Capacidad</th>
                                <th class="py-3 px-4 font-semibold text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-[#0A2334]">
                            @foreach($fichas as $ficha)
                                <tr class="border-b border-[#D8E6EB]/50 hover:bg-[#F1F8F7] transition-colors">
                                    <td class="py-3 px-4 font-medium">{{ $ficha->codigo }}</td>
                                    <td class="py-3 px-4">{{ $ficha->program->nombre ?? 'N/A' }}</td>
                                    <td class="py-3 px-4">{{ $ficha->capacidad_aprendices }}</td>
                                    <td class="py-3 px-4 text-right">
                                        <a href="{{ route('instructor.fichas.show', $ficha) }}" class="text-xs font-semibold text-[#0E6B54] hover:underline">Ver detalle</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-10">
                    <p class="text-sm text-[#5F7785]">No tienes fichas asignadas actualmente.</p>
                </div>
            @endif
        </section>
    </div>
@endsection
