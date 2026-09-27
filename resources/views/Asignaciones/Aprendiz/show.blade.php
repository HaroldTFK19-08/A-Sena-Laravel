@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Detalle de asignación')

@section('contenido')
    <div class="space-y-8">
        <x-portal.page-header
            eyebrow="Detalle de asignación"
            :title="$assignment->equipment?->name ?? 'Equipo no disponible'"
            :description="($assignment->equipment?->equipment_type ?? 'Equipo') . ' · ' . ($assignment->equipment?->brand ?? 'Sin marca registrada')"
        >
            <x-slot:actions>
                <a href="{{ route('aprendiz.asignaciones.index') }}" class="inline-flex items-center justify-center rounded-xl border border-[#C7DCE2] bg-white px-5 py-3 text-sm font-bold text-[#0A2334]">Volver a asignaciones</a>
            </x-slot:actions>
        </x-portal.page-header>

        <div class="grid gap-6 xl:grid-cols-[1.55fr_1fr]">
            <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)] md:p-8">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex h-24 w-24 shrink-0 items-center justify-center rounded-[26px] bg-[#D8F7CB] text-[#0E6B54]">
                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7 12 3 4 7m16 0-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                    </div>
                    <div class="flex-1 text-center sm:text-left"><p class="text-xs font-bold uppercase tracking-[0.18em] text-[#5F7785]">Equipo asignado</p><h2 class="mt-2 text-2xl font-black text-[#0A2334]">{{ $assignment->equipment?->name ?? 'Equipo eliminado' }}</h2><p class="mt-2 text-sm text-[#5F7785]">{{ $assignment->equipment?->brand ?? 'Sin marca' }} · {{ $assignment->equipment?->equipment_type ?? 'Sin tipo' }}</p></div>
                    <x-portal.status-badge :status="$assignment->Estado" />
                </div>
                <dl class="mt-8 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4"><dt class="text-[10px] font-bold uppercase tracking-[0.14em] text-[#78909C]">Fecha de asignación</dt><dd class="mt-2 text-lg font-black text-[#0A2334]">{{ $assignment->fecha_asignacion?->format('d/m/Y') ?? 'Sin fecha' }}</dd></div>
                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4"><dt class="text-[10px] font-bold uppercase tracking-[0.14em] text-[#78909C]">Fecha de devolución</dt><dd class="mt-2 text-lg font-black text-[#0A2334]">{{ $assignment->fecha_devolucion?->format('d/m/Y') ?? 'No definida' }}</dd></div>
                </dl>
            </section>

            <aside class="space-y-6">
                <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#5F7785]">Ubicación</p><h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Ambiente de uso</h2>
                    <div class="mt-5 rounded-2xl border border-[#CBE4D5] bg-[#EAFBF0] p-4"><p class="font-extrabold text-[#0A2334]">{{ $assignment->equipment?->environment?->nombre ?? 'Ambiente no registrado' }}</p><p class="mt-1 text-sm text-[#5F8B7C]">{{ $assignment->equipment?->environment?->tipo_ambiente ?? 'Sin tipo' }} · Capacidad {{ $assignment->equipment?->environment?->capacidad ?? '—' }}</p></div>
                </section>
                <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#5F7785]">Aprendiz</p><h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">{{ $aprendiz->user?->nombre_completo }}</h2><p class="mt-2 text-sm text-[#5F7785]">{{ $aprendiz->coursegroup?->codigo ?? 'Sin ficha' }} · {{ $aprendiz->estado }}</p>
                    <a href="{{ route('aprendiz.ficha') }}" class="mt-5 flex w-full items-center justify-center rounded-xl bg-[#0E6B54] px-4 py-3 text-sm font-bold text-white">Ir a mi ficha</a>
                </section>
            </aside>
        </div>
    </div>
@endsection
