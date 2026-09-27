@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Agenda docente')

@section('contenido')
    <div class="space-y-8">
        <x-portal.page-header
            eyebrow="Agenda docente"
            title="Línea de tiempo de formación"
            description="Consulta en un solo lugar los inicios y cierres de tus fichas, competencias, asignaciones y devoluciones programadas."
        >
            <x-slot:actions>
                <a href="{{ route('instructor.actividades') }}" class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30] transition hover:-translate-y-0.5">
                    Ver actividades
                </a>
            </x-slot:actions>
        </x-portal.page-header>

        <section class="grid grid-cols-2 gap-4 xl:grid-cols-4">
            <x-portal.metric label="Eventos" :value="$resumen['total']" description="En la agenda" icon="M12 6v6l4 2m4-8a10 10 0 1 1-20 0 10 10 0 0 1 20 0z" />
            <x-portal.metric label="Próximos" :value="$resumen['proximos']" description="Hoy o a futuro" icon="M5 12.5 8 15.5 19 1.5m0 11-3 3-7-7" tone="blue" />
            <x-portal.metric label="Fichas" :value="$resumen['fichas']" description="Grupos asignados" icon="M4 20h16M5 20V8.5L12 4l7 4.5V20M9 20v-5h6v5" tone="amber" />
            <x-portal.metric label="Competencias" :value="$resumen['competencias']" description="Periodos vinculados" icon="M4 19V5m0 14h16M8 16v-5m4 5V8m4 8v-9" tone="slate" />
        </section>

        @if ($eventos->isEmpty())
            <x-portal.empty-state
                title="Tu agenda está vacía"
                description="Agrega fechas a tus fichas o competencias y registra asignaciones para construir automáticamente tu línea de tiempo."
                icon="M12 6v6l4 2m4-8a10 10 0 1 1-20 0 10 10 0 0 1 20 0z"
            />
        @else
            <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)] md:p-8">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#5F7785]">Cronología</p>
                        <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Eventos de formación</h2>
                    </div>
                    <p class="text-xs font-semibold text-[#78909C]">Fechas ordenadas de menor a mayor</p>
                </div>

                <div class="mt-8 space-y-0">
                    @foreach ($eventos as $evento)
                        @php
                            $hoy = $evento['fecha']->isToday();
                            $pasado = $evento['fecha']->isPast() && ! $hoy;
                        @endphp
                        <a href="{{ $evento['ruta'] }}" class="group relative grid gap-4 pb-7 pl-0 sm:grid-cols-[92px_20px_minmax(0,1fr)] sm:gap-5">
                            @if (! $loop->last)
                                <span class="absolute bottom-0 left-[101px] top-5 hidden w-px bg-[#C9DCE3] sm:block" aria-hidden="true"></span>
                            @endif
                            <div class="sm:pt-1 sm:text-right">
                                <p class="text-xl font-black text-[#0A2334]">{{ $evento['fecha']->format('d') }}</p>
                                <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-[#78909C]">{{ $evento['fecha']->format('M Y') }}</p>
                            </div>
                            <span class="relative z-10 hidden h-5 w-5 items-center justify-center rounded-full border-4 border-[#F7FBFC] sm:flex {{ $hoy ? 'bg-[#39A900] ring-4 ring-[#8AFD5D]/30' : ($pasado ? 'bg-[#9AAAB4]' : 'bg-white ring-2 ring-[#39A900]') }}"></span>
                            <div class="rounded-2xl border bg-white p-4 transition duration-200 group-hover:-translate-y-0.5 group-hover:shadow-md {{ $hoy ? 'border-[#8AFD5D] ring-2 ring-[#8AFD5D]/20' : 'border-[#D8E6EB]' }} {{ $pasado ? 'opacity-70' : '' }}">
                                <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                    <div>
                                        <p class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-[#0E6B54]">{{ $evento['tipo'] }}</p>
                                        <h3 class="mt-1 font-extrabold text-[#0A2334]">{{ $evento['titulo'] }}</h3>
                                        <p class="mt-1 text-sm text-[#5F7785]">{{ $evento['descripcion'] }}</p>
                                    </div>
                                    <span class="shrink-0 rounded-full px-3 py-1 text-[10px] font-bold {{ $hoy ? 'bg-[#D8F7CB] text-[#0E6B54]' : ($pasado ? 'bg-slate-100 text-slate-600' : 'bg-[#E4EBFF] text-[#4B6BC8]') }}">
                                        {{ $hoy ? 'Hoy' : ($pasado ? 'Completado' : 'Programado') }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
