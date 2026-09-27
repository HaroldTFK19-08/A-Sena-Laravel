@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Detalle de ficha')

@section('contenido')
    <div class="space-y-8">
        <x-portal.page-header
            eyebrow="Detalle de ficha"
            :title="$ficha->codigo"
            :description="($ficha->program?->nombre ?? 'Programa no registrado') . ' · ' . ($ficha->program?->area?->nombre ?? 'Área no registrada')"
        >
            <x-slot:actions>
                <a href="{{ route('instructor.resultados.ficha', $ficha) }}" class="inline-flex items-center justify-center rounded-xl bg-[#0E6B54] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#0A5945]">
                    Ir a calificar
                </a>
                <a href="{{ route('instructor.fichas') }}" class="inline-flex items-center justify-center rounded-xl border border-[#C7DCE2] bg-white px-5 py-3 text-sm font-bold text-[#0A2334] transition hover:bg-[#F7FBFC]">
                    Volver a fichas
                </a>
            </x-slot:actions>
        </x-portal.page-header>

        <section class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <x-portal.metric label="Aprendices" :value="$resumen['aprendices']" description="Matrículas en la ficha" icon="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zm-8 9a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v1H8v-1z" />
            <x-portal.metric label="Activos" :value="$resumen['activos']" description="En proceso formativo" icon="M5 12.5 8 15.5 19 1.5m0 11-3 3-7-7" tone="blue" />
            <x-portal.metric label="Asignaciones" :value="$resumen['asignaciones']" description="Recursos entregados" icon="M20 7 12 3 4 7m16 0-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" tone="slate" />
            <x-portal.metric label="Instructores" :value="$resumen['instructores']" description="Docentes vinculados" icon="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zm-8 9a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v1H8v-1z" tone="amber" />
        </section>

        <div class="grid gap-6 xl:grid-cols-[1.7fr_1fr]">
            <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#5F7785]">Población</p>
                        <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Aprendices de la ficha</h2>
                    </div>
                    <a href="{{ route('instructor.aprendices', ['ficha' => $ficha->id]) }}" class="text-xs font-bold text-[#0E6B54] hover:underline">Ver todos</a>
                </div>

                @if ($ficha->apprentices->isEmpty())
                    <div class="mt-5"><x-portal.empty-state title="Sin aprendices" description="Esta ficha aún no tiene matrículas vinculadas." /></div>
                @else
                    <div class="mt-5 overflow-x-auto">
                        <table class="w-full min-w-[620px] text-left">
                            <thead class="text-xs uppercase tracking-[0.12em] text-[#5F7785]">
                                <tr class="border-b border-[#D8E6EB]"><th class="py-3 pr-4">Aprendiz</th><th class="px-4 py-3">Estado</th><th class="py-3 pl-4 text-right">Asignaciones</th></tr>
                            </thead>
                            <tbody>
                                @foreach ($ficha->apprentices as $aprendiz)
                                    <tr class="border-b border-[#D8E6EB]/60 last:border-0">
                                        <td class="py-4 pr-4 font-bold text-[#0A2334]">{{ $aprendiz->user?->nombre_completo ?? 'Aprendiz' }}<span class="mt-1 block text-xs font-normal text-[#78909C]">{{ $aprendiz->user?->identificacion }}</span></td>
                                        <td class="px-4 py-4"><x-portal.status-badge :status="$aprendiz->estado" /></td>
                                        <td class="py-4 pl-4 text-right font-black text-[#0E6B54]">{{ $aprendiz->assignments->count() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>

            <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#5F7785]">Equipo docente</p>
                <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Responsables</h2>
                <div class="mt-5 space-y-3">
                    @foreach ($ficha->teachers->where('id', '!=', $ficha->teacher_id) as $docente)
                        <div class="flex items-center gap-3 rounded-2xl border border-[#D8E6EB] bg-white p-4">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E4EBFF] font-black text-[#4B6BC8]">{{ strtoupper(substr($docente->user?->nombre_1 ?? 'I', 0, 1)) }}</span>
                            <div><p class="font-bold text-[#0A2334]">{{ $docente->user?->nombre_completo ?? 'Instructor' }}</p><p class="mt-0.5 text-xs text-[#78909C]">{{ $docente->especialidad ?? 'Docente vinculado' }}</p></div>
                        </div>
                    @endforeach
                    @if ($ficha->teacher)
                        <div class="flex items-center gap-3 rounded-2xl border border-[#CBE4D5] bg-[#EAFBF0] p-4">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#0E6B54] font-black text-white">{{ strtoupper(substr($ficha->teacher->user?->nombre_1 ?? 'I', 0, 1)) }}</span>
                            <div><p class="font-bold text-[#0A2334]">{{ $ficha->teacher->user?->nombre_completo ?? 'Instructor responsable' }}</p><p class="mt-0.5 text-xs text-[#5F8B7C]">Titular de la ficha</p></div>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection
