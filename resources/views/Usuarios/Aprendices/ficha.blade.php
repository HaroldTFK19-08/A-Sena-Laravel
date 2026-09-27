@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Mi ficha')

@section('contenido')
    <div class="space-y-8">
        <x-portal.page-header
            eyebrow="Mi proceso formativo"
            :title="$ficha?->codigo ?? 'Ficha no asignada'"
            :description="($ficha?->program?->nombre ?? 'Completa y actualiza tu perfil para vincularte a una ficha.') . ' · ' . ($ficha?->program?->nivel_programa ?? 'Sin nivel')"
        >
            <x-slot:actions>
                <a href="{{ route('aprendiz.cronograma') }}" class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30] transition hover:-translate-y-0.5">
                    Ver cronograma
                </a>
                @if (! $ficha)
                    <a href="{{ route('aprendiz.edit') }}" class="inline-flex items-center justify-center rounded-xl border border-[#C7DCE2] bg-white px-5 py-3 text-sm font-bold text-[#0A2334]">Actualizar perfil</a>
                @endif
            </x-slot:actions>
        </x-portal.page-header>

        @unless ($ficha)
            <x-portal.empty-state
                title="Aún no tienes una ficha asignada"
                description="Actualiza tu perfil para seleccionar la ficha que te corresponde. Un administrador podrá validar la asignación posteriormente."
                icon="M4 20h16M5 20V8.5L12 4l7 4.5V20M9 20v-5h6v5"
            >
                <x-slot:action>
                    <a href="{{ route('aprendiz.edit') }}" class="rounded-xl bg-[#0E6B54] px-5 py-3 text-sm font-bold text-white">Actualizar mi perfil</a>
                </x-slot:action>
            </x-portal.empty-state>
        @else
            <section class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
                <x-portal.metric label="Asignaciones" :value="$resumen['asignaciones']" description="Equipos recibidos" icon="M9 12h6m-6 4h6M7 7h10a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2z" />
                <x-portal.metric label="En uso" :value="$resumen['asignaciones_activas']" description="Asignaciones activas" icon="M5 12.5 8 15.5 19 1.5m0 11-3 3-7-7" tone="blue" />
                <x-portal.metric label="Resultados" :value="$resumen['resultados']" description="Evaluaciones registradas" icon="M4 19V5m0 14h16M8 16v-5m4 5V8m4 8v-9" tone="slate" />
                <x-portal.metric label="Aprobados" :value="$resumen['aprobados']" description="Resultados aprobados" icon="M5 12l4 4L19 7" tone="amber" />
            </section>

            <div class="grid gap-6 xl:grid-cols-[1.55fr_1fr]">
                <div class="space-y-6">
                    <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#5F7785]">Información de la ficha</p>
                        <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Datos de formación</h2>
                        <dl class="mt-6 grid gap-4 sm:grid-cols-2">
                            <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4"><dt class="text-[10px] font-bold uppercase tracking-[0.14em] text-[#78909C]">Programa</dt><dd class="mt-2 font-extrabold text-[#0A2334]">{{ $ficha->program?->nombre ?? 'No registrado' }}</dd></div>
                            <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4"><dt class="text-[10px] font-bold uppercase tracking-[0.14em] text-[#78909C]">Área</dt><dd class="mt-2 font-extrabold text-[#0A2334]">{{ $ficha->program?->area?->nombre ?? 'No registrada' }}</dd></div>
                            <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4"><dt class="text-[10px] font-bold uppercase tracking-[0.14em] text-[#78909C]">Inicio</dt><dd class="mt-2 font-extrabold text-[#0A2334]">{{ $aprendiz->fecha_inicio?->format('d/m/Y') ?? 'No registrada' }}</dd></div>
                            <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4"><dt class="text-[10px] font-bold uppercase tracking-[0.14em] text-[#78909C]">Finalización</dt><dd class="mt-2 font-extrabold text-[#0A2334]">{{ $aprendiz->fecha_fin?->format('d/m/Y') ?? 'No definida' }}</dd></div>
                        </dl>
                    </section>

                    <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                        <div class="flex items-center justify-between gap-3"><div><p class="text-xs font-bold uppercase tracking-[0.2em] text-[#5F7785]">Plan académico</p><h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Competencias</h2></div><span class="rounded-full bg-[#E4EBFF] px-3 py-1 text-xs font-bold text-[#4B6BC8]">{{ $competencias->count() }}</span></div>
                        @if ($competencias->isEmpty())
                            <p class="mt-5 rounded-2xl border border-dashed border-[#C9DCE3] bg-white p-6 text-center text-sm text-[#5F7785]">No hay competencias vinculadas todavía.</p>
                        @else
                            <div class="mt-5 space-y-3">
                                @foreach ($competencias as $competencia)
                                    <div class="flex flex-col gap-3 rounded-2xl border border-[#D8E6EB] bg-white p-4 sm:flex-row sm:items-center sm:justify-between">
                                        <div><p class="text-xs font-bold text-[#0E6B54]">{{ $competencia->codigo ?? 'Competencia' }}</p><p class="mt-1 font-extrabold text-[#0A2334]">{{ $competencia->nombre }}</p><p class="mt-1 text-xs text-[#78909C]">{{ $competencia->fecha_inicio?->format('d/m/Y') }} — {{ $competencia->fecha_fin?->format('d/m/Y') }}</p></div>
                                        <span class="shrink-0 rounded-full bg-[#EAF6F4] px-3 py-1 text-xs font-bold text-[#0E6B54]">{{ $competencia->results_count }} resultados</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </section>
                </div>

                <aside class="space-y-6">
                    <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#5F7785]">Estado</p>
                        <div class="mt-5 flex items-center justify-between"><span class="text-sm text-[#5F7785]">Proceso</span><x-portal.status-badge :status="$aprendiz->estado" /></div>
                        <div class="mt-4 flex items-center justify-between"><span class="text-sm text-[#5F7785]">Instructor titular</span><span class="text-right text-sm font-bold text-[#0A2334]">{{ $ficha->teacher?->user?->nombre_completo ?? 'No asignado' }}</span></div>
                        <a href="{{ route('aprendiz.resultados.index') }}" class="mt-6 flex w-full items-center justify-center rounded-xl bg-[#0E6B54] px-4 py-3 text-sm font-bold text-white">Consultar resultados</a>
                    </section>

                    <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                        <div class="flex items-center justify-between"><div><p class="text-xs font-bold uppercase tracking-[0.2em] text-[#5F7785]">Recursos</p><h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Últimas asignaciones</h2></div><a href="{{ route('aprendiz.asignaciones.index') }}" class="text-xs font-bold text-[#0E6B54]">Ver todas</a></div>
                        <div class="mt-5 space-y-3">
                            @forelse ($aprendiz->assignments->sortByDesc('fecha_asignacion')->take(3) as $asignacion)
                                <a href="{{ route('aprendiz.asignaciones.show', $asignacion) }}" class="block rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:border-[#8AFD5D]/60">
                                    <div class="flex items-start justify-between gap-3"><p class="font-extrabold text-[#0A2334]">{{ $asignacion->equipment?->name ?? 'Equipo' }}</p><x-portal.status-badge :status="$asignacion->Estado" /></div>
                                    <p class="mt-2 text-xs text-[#78909C]">{{ $asignacion->fecha_asignacion?->format('d/m/Y') }} · {{ $asignacion->equipment?->environment?->nombre ?? 'Sin ambiente' }}</p>
                                </a>
                            @empty
                                <p class="rounded-2xl border border-dashed border-[#C9DCE3] bg-white p-5 text-center text-sm text-[#5F7785]">Todavía no tienes equipos asignados.</p>
                            @endforelse
                        </div>
                    </section>
                </aside>
            </div>
        @endunless
    </div>
@endsection
