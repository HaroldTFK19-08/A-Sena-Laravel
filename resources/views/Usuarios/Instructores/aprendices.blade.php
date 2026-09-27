@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Aprendices asignados')

@section('contenido')
    <div class="space-y-8">
        <x-portal.page-header
            eyebrow="Gestión docente"
            title="Aprendices asignados"
            description="Consulta únicamente los aprendices vinculados a tus fichas, con su estado formativo, recursos asignados y avance de resultados."
        >
            <x-slot:actions>
                <a href="{{ route('instructor.fichas') }}" class="inline-flex items-center justify-center rounded-xl border border-[#C7DCE2] bg-white px-5 py-3 text-sm font-bold text-[#0A2334] transition hover:bg-[#F7FBFC]">
                    Ver mis fichas
                </a>
            </x-slot:actions>
        </x-portal.page-header>

        <section class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <x-portal.metric label="Aprendices" :value="$resumen['total']" description="En tus fichas" icon="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zm-8 9a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v1H8v-1z" />
            <x-portal.metric label="Activos" :value="$resumen['activos']" description="Proceso en curso" icon="M5 12.5 8 15.5 19 1.5m0 11-3 3-7-7" tone="blue" />
            <x-portal.metric label="Certificados" :value="$resumen['certificados']" description="Proceso finalizado" icon="M12 4v16m8-8H4" tone="amber" />
            <x-portal.metric label="Asignaciones" :value="$resumen['asignaciones']" description="Equipos registrados" icon="M20 7 12 3 4 7m16 0-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" tone="slate" />
        </section>

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)] md:p-6">
            <form method="GET" class="grid gap-3 sm:grid-cols-[minmax(0,1fr)_190px_auto]" aria-label="Filtrar aprendices">
                @if (request('ficha'))
                    <input type="hidden" name="ficha" value="{{ request('ficha') }}">
                @endif
                <label class="relative">
                    <span class="sr-only">Buscar aprendiz</span>
                    <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-[#78909C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m21 21-4.35-4.35m2.35-5.15a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                    </svg>
                    <input type="search" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre o identificación" class="h-12 w-full rounded-xl border border-[#D8E6EB] bg-white pl-12 pr-4 text-sm text-[#0A2334] outline-none transition focus:border-[#39A900] focus:ring-4 focus:ring-[#8AFD5D]/20" />
                </label>
                <label>
                    <span class="sr-only">Filtrar por estado</span>
                    <select name="estado" class="h-12 w-full rounded-xl border border-[#D8E6EB] bg-white px-4 text-sm text-[#0A2334] outline-none transition focus:border-[#39A900] focus:ring-4 focus:ring-[#8AFD5D]/20">
                        <option value="">Todos los estados</option>
                        @foreach (['Activo', 'Retirado', 'Certificado'] as $opcion)
                            <option value="{{ $opcion }}" @selected($estado === $opcion)>{{ $opcion }}</option>
                        @endforeach
                    </select>
                </label>
                <button class="h-12 rounded-xl bg-[#0E6B54] px-6 text-sm font-bold text-white transition hover:bg-[#0A5945]">Aplicar</button>
            </form>
        </section>

        @if ($aprendices->isEmpty())
            <x-portal.empty-state
                title="No se encontraron aprendices"
                description="Prueba cambiando los filtros o verifica que tus fichas tengan aprendices asignados."
                icon="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zm-8 9a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v1H8v-1z"
            />
        @else
            <section class="overflow-hidden rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[820px] text-left">
                        <thead class="bg-white/70 text-xs uppercase tracking-[0.12em] text-[#5F7785]">
                            <tr class="border-b border-[#D8E6EB]">
                                <th class="px-6 py-4 font-bold">Aprendiz</th>
                                <th class="px-4 py-4 font-bold">Ficha</th>
                                <th class="px-4 py-4 font-bold">Estado</th>
                                <th class="px-4 py-4 font-bold">Inicio</th>
                                <th class="px-4 py-4 text-center font-bold">Asignaciones</th>
                                <th class="px-4 py-4 text-center font-bold">Resultados</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aprendices as $aprendiz)
                                <tr class="border-b border-[#D8E6EB]/60 bg-white/40 transition last:border-0 hover:bg-white">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#D8F7CB] font-black text-[#0E6B54]">{{ strtoupper(substr($aprendiz->user?->nombre_1 ?? 'A', 0, 1)) }}</span>
                                            <div>
                                                <p class="font-bold text-[#0A2334]">{{ $aprendiz->user?->nombre_completo ?? 'Aprendiz sin nombre' }}</p>
                                                <p class="mt-0.5 text-xs text-[#6C8492]">{{ $aprendiz->user?->identificacion ?? 'Sin identificación' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <p class="font-bold text-[#0E6B54]">{{ $aprendiz->coursegroup?->codigo ?? 'Sin ficha' }}</p>
                                        <p class="mt-1 max-w-xs truncate text-xs text-[#6C8492]">{{ $aprendiz->coursegroup?->program?->nombre ?? 'Programa no registrado' }}</p>
                                    </td>
                                    <td class="px-4 py-4"><x-portal.status-badge :status="$aprendiz->estado" /></td>
                                    <td class="px-4 py-4 text-sm text-[#456073]">{{ $aprendiz->fecha_inicio?->format('d/m/Y') ?? 'No registrada' }}</td>
                                    <td class="px-4 py-4 text-center text-sm font-bold text-[#0A2334]">{{ $aprendiz->assignments_count }}</td>
                                    <td class="px-4 py-4 text-center text-sm font-bold text-[#0A2334]">{{ $aprendiz->grades_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-[#D8E6EB] bg-white/40 px-6 py-4">
                    {{ $aprendices->links() }}
                </div>
            </section>
        @endif
    </div>
@endsection
