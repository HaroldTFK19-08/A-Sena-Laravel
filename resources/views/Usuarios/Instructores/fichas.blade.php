@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Mis fichas')

@section('contenido')
    <div class="space-y-8">
        <x-portal.page-header
            eyebrow="Gestión docente"
            title="Mis fichas de formación"
            description="Revisa los grupos asignados, su programa, claustro docente, capacidad y cantidad de aprendices vinculados."
        >
            <x-slot:actions>
                <a href="{{ route('instructor.aprendices') }}" class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30] transition hover:-translate-y-0.5">
                    Ver aprendices
                </a>
            </x-slot:actions>
        </x-portal.page-header>

        <section class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <x-portal.metric label="Fichas" :value="$resumen['total']" description="Grupos a tu cargo" icon="M4 20h16M5 20V8.5L12 4l7 4.5V20M9 20v-5h6v5" />
            <x-portal.metric label="Aprendices" :value="$resumen['aprendices']" description="Matrículas vinculadas" icon="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zm-8 9a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v1H8v-1z" tone="blue" />
            <x-portal.metric label="Cupos disponibles" :value="$resumen['disponibles']" description="En las fichas asignadas" icon="M12 4v16m8-8H4" tone="amber" />
        </section>

        @if ($fichas->isEmpty())
            <x-portal.empty-state
                title="Aún no tienes fichas asignadas"
                description="Cuando un administrador te asigne una ficha, aparecerá aquí con toda su información académica."
                icon="M4 20h16M5 20V8.5L12 4l7 4.5V20M9 20v-5h6v5"
            />
        @else
            <section class="grid grid-cols-1 gap-5 md:grid-cols-2">
                @foreach ($fichas as $ficha)
                    @php
                        $ocupacion = $ficha->capacidad_aprendices > 0
                            ? min(100, (int) round(($ficha->apprentices_count / $ficha->capacidad_aprendices) * 100))
                            : 0;
                        $instructores = collect($ficha->teacher_id)
                            ->push($ficha->teacher?->id)
                            ->merge($ficha->teachers->pluck('id'))
                            ->filter()
                            ->unique();
                    @endphp
                    <a href="{{ route('instructor.fichas.show', $ficha) }}" class="group rounded-[28px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)] transition duration-200 hover:-translate-y-1 hover:border-[#8AFD5D]/60 hover:bg-white hover:shadow-xl">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <span class="rounded-full bg-[#E4EBFF] px-3 py-1 text-[10px] font-extrabold uppercase tracking-[0.16em] text-[#4B6BC8]">{{ $ficha->program?->nivel_programa ?? 'Programa' }}</span>
                                <h2 class="mt-4 text-xl font-black text-[#0A2334]">{{ $ficha->codigo }}</h2>
                                <p class="mt-1 text-sm leading-relaxed text-[#5F7785]">{{ $ficha->program?->nombre ?? 'Programa no registrado' }}</p>
                            </div>
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#D8F7CB] text-[#0E6B54] transition group-hover:scale-105">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 20h16M5 20V8.5L12 4l7 4.5V20M9 20v-5h6v5" /></svg>
                            </span>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <div class="rounded-2xl bg-white p-3.5 ring-1 ring-[#E3EDF1]">
                                <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-[#78909C]">Aprendices</p>
                                <p class="mt-1.5 text-lg font-black text-[#0A2334]">{{ $ficha->apprentices_count }} / {{ $ficha->capacidad_aprendices }}</p>
                            </div>
                            <div class="rounded-2xl bg-white p-3.5 ring-1 ring-[#E3EDF1]">
                                <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-[#78909C]">Equipo docente</p>
                                <p class="mt-1.5 text-lg font-black text-[#0A2334]">{{ $instructores->count() }}</p>
                            </div>
                        </div>

                        <div class="mt-5">
                            <div class="mb-2 flex items-center justify-between text-xs font-bold text-[#5F7785]">
                                <span>Ocupación</span><span>{{ $ocupacion }}%</span>
                            </div>
                            <div class="h-2 overflow-hidden rounded-full bg-[#DDEAF0]">
                                <div class="h-full rounded-full bg-[#39A900]" style="width: {{ $ocupacion }}%"></div>
                            </div>
                        </div>

                        <p class="mt-6 inline-flex items-center gap-2 text-sm font-extrabold text-[#0E6B54]">
                            Ver ficha completa
                            <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" /></svg>
                        </p>
                    </a>
                @endforeach
            </section>

            <div class="rounded-[26px] border border-[#D8E6EB] bg-white p-4 shadow-sm">
                {{ $fichas->links() }}
            </div>
        @endif
    </div>
@endsection
