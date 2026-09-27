@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Actividades')

@section('contenido')
    <div class="space-y-8">
        <x-portal.page-header
            eyebrow="Seguimiento de formación"
            title="Actividades de mis aprendices"
            description="Consulta los equipos entregados a los aprendices de tus fichas, sus ambientes y las fechas de uso o devolución."
        >
            <x-slot:actions>
                @if (auth()->user()?->teacher)
                    <a href="{{ route('instructor.asignaciones.create') }}" class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30] transition hover:-translate-y-0.5">
                        Nueva asignación
                    </a>
                @else
                    <a href="{{ route('instructor.edit') }}" class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30] transition hover:-translate-y-0.5">
                        Completar perfil
                    </a>
                @endif
            </x-slot:actions>
        </x-portal.page-header>

        <section class="grid grid-cols-2 gap-4 xl:grid-cols-4">
            <x-portal.metric label="Actividades" :value="$resumen['total']" description="Total registrado" icon="M9 12h6m-6 4h6M7 7h10a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2z" />
            <x-portal.metric label="En uso" :value="$resumen['activas']" description="Actividades activas" icon="M5 12.5 8 15.5 19 1.5m0 11-3 3-7-7" tone="blue" />
            <x-portal.metric label="Finalizadas" :value="$resumen['finalizadas']" description="Actividades inactivas" icon="M5 12l4 4L19 7" tone="slate" />
            <x-portal.metric label="Aprendices" :value="$resumen['aprendices']" description="En tus fichas" icon="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zm-8 9a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v1H8v-1z" tone="amber" />
        </section>

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)] md:p-6">
            <form method="GET" class="grid gap-3 sm:grid-cols-[minmax(0,1fr)_180px_auto]" aria-label="Filtrar actividades">
                <label class="relative">
                    <span class="sr-only">Buscar actividad</span>
                    <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-[#78909C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m21 21-4.35-4.35m2.35-5.15a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" /></svg>
                    <input type="search" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar equipo, marca o aprendiz" class="h-12 w-full rounded-xl border border-[#D8E6EB] bg-white pl-12 pr-4 text-sm text-[#0A2334] outline-none transition focus:border-[#39A900] focus:ring-4 focus:ring-[#8AFD5D]/20" />
                </label>
                <label>
                    <span class="sr-only">Filtrar por estado</span>
                    <select name="estado" class="h-12 w-full rounded-xl border border-[#D8E6EB] bg-white px-4 text-sm text-[#0A2334] outline-none transition focus:border-[#39A900] focus:ring-4 focus:ring-[#8AFD5D]/20">
                        <option value="">Todos los estados</option>
                        @foreach (['Activo', 'Inactivo'] as $opcion)
                            <option value="{{ $opcion }}" @selected($estado === $opcion)>{{ $opcion }}</option>
                        @endforeach
                    </select>
                </label>
                <button class="h-12 rounded-xl bg-[#0E6B54] px-6 text-sm font-bold text-white transition hover:bg-[#0A5945]">Aplicar</button>
            </form>
        </section>

        @if ($actividades->isEmpty())
            <x-portal.empty-state
                title="No hay actividades para mostrar"
                description="No encontramos registros que coincidan con los filtros seleccionados."
                icon="M9 12h6m-6 4h6M7 7h10a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2z"
            />
        @else
            <section class="overflow-hidden rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[860px] text-left">
                        <thead class="bg-white/70 text-xs uppercase tracking-[0.12em] text-[#5F7785]">
                            <tr class="border-b border-[#D8E6EB]"><th class="px-6 py-4">Equipo</th><th class="px-4 py-4">Aprendiz</th><th class="px-4 py-4">Ambiente</th><th class="px-4 py-4">Fechas</th><th class="px-4 py-4">Estado</th><th class="px-6 py-4 text-right">Acción</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($actividades as $actividad)
                                <tr class="border-b border-[#D8E6EB]/60 last:border-0 hover:bg-white">
                                    <td class="px-6 py-4"><p class="font-extrabold text-[#0A2334]">{{ $actividad->equipment?->name ?? 'Equipo eliminado' }}</p><p class="mt-1 text-xs text-[#78909C]">{{ $actividad->equipment?->brand ?? 'Sin marca' }} · {{ $actividad->equipment?->equipment_type ?? 'Sin tipo' }}</p></td>
                                    <td class="px-4 py-4"><p class="font-bold text-[#0A2334]">{{ $actividad->apprentice?->user?->nombre_completo ?? 'Aprendiz' }}</p><p class="mt-1 text-xs text-[#78909C]">{{ $actividad->apprentice?->coursegroup?->codigo ?? 'Sin ficha' }}</p></td>
                                    <td class="px-4 py-4 text-sm text-[#456073]">{{ $actividad->equipment?->environment?->nombre ?? 'No registrado' }}</td>
                                    <td class="px-4 py-4 text-xs leading-relaxed text-[#5F7785]"><span class="block">Asignación: {{ $actividad->fecha_asignacion?->format('d/m/Y') ?? 'Sin fecha' }}</span><span class="block">Devolución: {{ $actividad->fecha_devolucion?->format('d/m/Y') ?? 'No definida' }}</span></td>
                                    <td class="px-4 py-4"><x-portal.status-badge :status="$actividad->Estado" /></td>
                                    <td class="px-6 py-4 text-right"><a href="{{ route('instructor.asignaciones.show', $actividad) }}" class="inline-flex rounded-lg border border-[#D8E6EB] bg-white px-3 py-1.5 text-xs font-bold text-[#0E6B54] hover:bg-[#F1F8F7]">Ver detalle</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-[#D8E6EB] bg-white/40 px-6 py-4">{{ $actividades->links() }}</div>
            </section>
        @endif
    </div>
@endsection
