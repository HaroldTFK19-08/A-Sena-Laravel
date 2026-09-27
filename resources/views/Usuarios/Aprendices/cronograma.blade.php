@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Mi cronograma')

@section('contenido')
    <div class="space-y-8">
        <x-portal.page-header
            eyebrow="Mi proceso formativo"
            title="Cronograma de aprendizaje"
            description="Consulta las fechas de tu formación, competencias, asignaciones y entregas. Los registros se generan a partir de tu información académica real."
        >
            <x-slot:actions>
                <a href="{{ route('aprendiz.ficha') }}" class="inline-flex items-center justify-center rounded-xl border border-[#C7DCE2] bg-white px-5 py-3 text-sm font-bold text-[#0A2334] transition hover:bg-[#F7FBFC]">Ver mi ficha</a>
                @if (auth()->user()?->apprentice)
                    <a href="{{ route('aprendiz.resultados.index') }}" class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30]">Ver resultados</a>
                @else
                    <a href="{{ route('aprendiz.edit') }}" class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30]">Completar perfil</a>
                @endif
            </x-slot:actions>
        </x-portal.page-header>

        <section class="grid grid-cols-2 gap-4 xl:grid-cols-4">
            <x-portal.metric label="Eventos" :value="$resumen['total']" description="En tu cronograma" icon="M12 6v6l4 2m4-8a10 10 0 1 1-20 0 10 10 0 0 1 20 0z" />
            <x-portal.metric label="Próximos" :value="$resumen['proximos']" description="Hoy o a futuro" icon="M5 12.5 8 15.5 19 1.5m0 11-3 3-7-7" tone="blue" />
            <x-portal.metric label="Competencias" :value="$resumen['competencias']" description="Periodos académicos" icon="M4 19V5m0 14h16M8 16v-5m4 5V8m4 8v-9" tone="amber" />
            <x-portal.metric label="Asignaciones" :value="$resumen['asignaciones']" description="Recursos entregados" icon="M20 7 12 3 4 7m16 0-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" tone="slate" />
        </section>

        @if ($eventos->isEmpty())
            <x-portal.empty-state title="No hay fechas para mostrar" description="Cuando tu ficha, competencias o asignaciones tengan fechas registradas, aparecerán aquí en orden cronológico." icon="M12 6v6l4 2m4-8a10 10 0 1 1-20 0 10 10 0 0 1 20 0z" />
        @else
            <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)] md:p-8">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div><p class="text-xs font-bold uppercase tracking-[0.2em] text-[#5F7785]">Línea de tiempo</p><h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Mi agenda</h2></div>
                    <a href="{{ route('aprendiz.asignaciones.index') }}" class="text-xs font-bold text-[#0E6B54] hover:underline">Consultar asignaciones</a>
                </div>

                <div class="mt-8 space-y-3">
                    @foreach ($eventos as $evento)
                        @php
                            $hoy = $evento['fecha']->isToday();
                            $pasado = $evento['fecha']->isPast() && ! $hoy;
                        @endphp
                        <a href="{{ $evento['ruta'] }}" class="group grid gap-4 rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:-translate-y-0.5 hover:border-[#8AFD5D]/60 hover:shadow-md sm:grid-cols-[84px_130px_minmax(0,1fr)_auto] sm:items-center sm:p-5 {{ $pasado ? 'opacity-70' : '' }}">
                            <div class="flex items-center gap-3 sm:block sm:text-center">
                                <p class="text-2xl font-black text-[#0A2334]">{{ $evento['fecha']->format('d') }}</p>
                                <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-[#78909C]">{{ $evento['fecha']->format('M Y') }}</p>
                            </div>
                            <div><span class="rounded-full bg-[#EAF6F4] px-3 py-1 text-[10px] font-extrabold uppercase tracking-[0.12em] text-[#0E6B54]">{{ $evento['tipo'] }}</span></div>
                            <div class="min-w-0"><h3 class="font-extrabold text-[#0A2334]">{{ $evento['titulo'] }}</h3><p class="mt-1 text-sm text-[#5F7785]">{{ $evento['descripcion'] }}</p></div>
                            <span class="justify-self-start rounded-full px-3 py-1 text-[10px] font-bold sm:justify-self-end {{ $hoy ? 'bg-[#D8F7CB] text-[#0E6B54]' : ($pasado ? 'bg-slate-100 text-slate-600' : 'bg-[#E4EBFF] text-[#4B6BC8]') }}">{{ $hoy ? 'Hoy' : ($pasado ? 'Completado' : 'Programado') }}</span>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
