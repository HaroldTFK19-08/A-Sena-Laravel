@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Mis asignaciones')

@section('contenido')
    <div class="space-y-8">
        <x-portal.page-header
            eyebrow="Recursos de aprendizaje"
            title="Mis asignaciones"
            description="Consulta los equipos que tienes asignados, el ambiente donde se utilizan y las fechas de entrega o devolución."
        >
            <x-slot:actions>
                <a href="{{ route('aprendiz.cronograma') }}" class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30]">Ver cronograma</a>
            </x-slot:actions>
        </x-portal.page-header>

        <section class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <x-portal.metric label="Asignaciones" :value="$resumen['total']" description="Total recibido" icon="M9 12h6m-6 4h6M7 7h10a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2z" />
            <x-portal.metric label="En uso" :value="$resumen['activas']" description="Equipos activos" icon="M5 12.5 8 15.5 19 1.5m0 11-3 3-7-7" tone="blue" />
            <x-portal.metric label="Devueltas" :value="$resumen['devueltas']" description="Con fecha de entrega" icon="M5 12l4 4L19 7" tone="slate" />
        </section>

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)] md:p-6">
            <form method="GET" class="grid gap-3 sm:grid-cols-[minmax(0,1fr)_180px_auto]" aria-label="Filtrar asignaciones">
                <label class="relative"><span class="sr-only">Buscar equipo</span><svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-[#78909C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m21 21-4.35-4.35m2.35-5.15a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" /></svg><input type="search" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por equipo, marca o tipo" class="h-12 w-full rounded-xl border border-[#D8E6EB] bg-white pl-12 pr-4 text-sm text-[#0A2334] outline-none transition focus:border-[#39A900] focus:ring-4 focus:ring-[#8AFD5D]/20" /></label>
                <label><span class="sr-only">Filtrar por estado</span><select name="estado" class="h-12 w-full rounded-xl border border-[#D8E6EB] bg-white px-4 text-sm text-[#0A2334] outline-none transition focus:border-[#39A900] focus:ring-4 focus:ring-[#8AFD5D]/20"><option value="">Todos los estados</option>@foreach (['Activo', 'Inactivo'] as $opcion)<option value="{{ $opcion }}" @selected($estado === $opcion)>{{ $opcion }}</option>@endforeach</select></label>
                <button class="h-12 rounded-xl bg-[#0E6B54] px-6 text-sm font-bold text-white transition hover:bg-[#0A5945]">Aplicar</button>
            </form>
        </section>

        @if ($asignaciones->isEmpty())
            <x-portal.empty-state title="No tienes asignaciones" description="Cuando un instructor te entregue un equipo, podrás consultar aquí su detalle y fecha de devolución." icon="M20 7 12 3 4 7m16 0-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        @else
            <section class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($asignaciones as $asignacion)
                    <a href="{{ route('aprendiz.asignaciones.show', $asignacion) }}" class="group rounded-[28px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)] transition duration-200 hover:-translate-y-1 hover:border-[#8AFD5D]/60 hover:bg-white hover:shadow-xl">
                        <div class="flex items-start justify-between gap-4"><div class="min-w-0"><p class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-[#0E6B54]">{{ $asignacion->equipment?->equipment_type ?? 'Equipo' }}</p><h2 class="mt-2 truncate text-xl font-black text-[#0A2334]">{{ $asignacion->equipment?->name ?? 'Equipo eliminado' }}</h2><p class="mt-1 text-sm text-[#78909C]">{{ $asignacion->equipment?->brand ?? 'Sin marca registrada' }}</p></div><x-portal.status-badge :status="$asignacion->Estado" /></div>
                        <div class="mt-6 rounded-2xl bg-white p-4 ring-1 ring-[#E3EDF1]"><p class="text-[10px] font-bold uppercase tracking-[0.14em] text-[#78909C]">Ambiente</p><p class="mt-2 font-extrabold text-[#0A2334]">{{ $asignacion->equipment?->environment?->nombre ?? 'No registrado' }}</p></div>
                        <dl class="mt-5 grid grid-cols-2 gap-4 text-xs"><div><dt class="font-bold uppercase tracking-wider text-[#78909C]">Asignación</dt><dd class="mt-1.5 font-bold text-[#0A2334]">{{ $asignacion->fecha_asignacion?->format('d/m/Y') ?? 'Sin fecha' }}</dd></div><div><dt class="font-bold uppercase tracking-wider text-[#78909C]">Devolución</dt><dd class="mt-1.5 font-bold text-[#0A2334]">{{ $asignacion->fecha_devolucion?->format('d/m/Y') ?? 'No definida' }}</dd></div></dl>
                        <p class="mt-6 inline-flex items-center gap-2 text-sm font-extrabold text-[#0E6B54]">Ver detalle <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" /></svg></p>
                    </a>
                @endforeach
            </section>
            <div class="rounded-[26px] border border-[#D8E6EB] bg-white p-4 shadow-sm">{{ $asignaciones->links() }}</div>
        @endif
    </div>
@endsection
