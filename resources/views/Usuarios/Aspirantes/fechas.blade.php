@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Fechas de admisión')

@section('contenido')
    <div class="space-y-8">
        <x-portal.page-header
            eyebrow="Proceso de admisión"
            title="Fechas de mi proceso"
            description="Consulta las fechas de inscripción, convocatoria, pruebas y publicación de resultados vinculadas a cada una de tus solicitudes."
        >
            <x-slot:actions>
                @if (auth()->user()?->aspirant)
                    <a href="{{ route('aspirante.inscripciones.index') }}" class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30] transition hover:-translate-y-0.5">Ver inscripciones</a>
                    <a href="{{ route('aspirante.ofertas.index') }}" class="inline-flex items-center justify-center rounded-xl border border-[#F6D3D0] bg-white px-5 py-3 text-sm font-bold text-[#A94F45]">Explorar ofertas</a>
                @else
                    <a href="{{ route('aspirante.edit') }}" class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30] transition hover:-translate-y-0.5">Completar perfil</a>
                @endif
            </x-slot:actions>
        </x-portal.page-header>

        <section class="grid grid-cols-2 gap-4 xl:grid-cols-4">
            <x-portal.metric label="Eventos" :value="$resumen['total']" description="Fechas registradas" icon="M12 6v6l4 2m4-8a10 10 0 1 1-20 0 10 10 0 0 1 20 0z" />
            <x-portal.metric label="Próximos" :value="$resumen['proximos']" description="Hoy o a futuro" icon="M5 12.5 8 15.5 19 1.5m0 11-3 3-7-7" tone="rose" />
            <x-portal.metric label="Inscripciones" :value="$resumen['inscripciones']" description="Procesos registrados" icon="M7 7h10v10H7zM9 10h6M9 14h4" tone="amber" />
            <x-portal.metric label="Activas" :value="$resumen['activas']" description="No canceladas" icon="M5 12l4 4L19 7" tone="blue" />
        </section>

        @if ($eventos->isEmpty())
            <x-portal.empty-state
                title="Todavía no tienes fechas registradas"
                description="Inscríbete en una oferta o completa tu perfil. Las fechas se generarán automáticamente desde cada convocatoria."
                icon="M12 6v6l4 2m4-8a10 10 0 1 1-20 0 10 10 0 0 1 20 0z"
            >
                <x-slot:action>
                    <a href="{{ route('aspirante.ofertas.index') }}" class="rounded-xl bg-[#0E6B54] px-5 py-3 text-sm font-bold text-white">Ver ofertas disponibles</a>
                </x-slot:action>
            </x-portal.empty-state>
        @else
            <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)] md:p-8">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div><p class="text-xs font-bold uppercase tracking-[0.2em] text-[#5F7785]">Cronología</p><h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Fechas por inscripción</h2></div>
                    <p class="text-xs font-semibold text-[#78909C]">Actualizado con la información de las ofertas</p>
                </div>

                <div class="mt-8 space-y-3">
                    @foreach ($eventos as $evento)
                        @php
                            $hoy = $evento['fecha']->isToday();
                            $pasado = $evento['fecha']->isPast() && ! $hoy;
                        @endphp
                        <a href="{{ $evento['ruta'] }}" class="group grid gap-4 rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:-translate-y-0.5 hover:border-[#FFB0A5]/60 hover:shadow-md sm:grid-cols-[84px_140px_minmax(0,1fr)_auto] sm:items-center sm:p-5 {{ $pasado ? 'opacity-70' : '' }}">
                            <div class="flex items-center gap-3 sm:block sm:text-center"><p class="text-2xl font-black text-[#0A2334]">{{ $evento['fecha']->format('d') }}</p><p class="text-[10px] font-bold uppercase tracking-[0.14em] text-[#78909C]">{{ $evento['fecha']->format('M Y') }}</p></div>
                            <div><span class="rounded-full bg-[#FFE9E6] px-3 py-1 text-[10px] font-extrabold uppercase tracking-[0.12em] text-[#A94F45]">{{ $evento['tipo'] }}</span></div>
                            <div class="min-w-0"><h3 class="font-extrabold text-[#0A2334]">{{ $evento['titulo'] }}</h3><p class="mt-1 text-sm text-[#5F7785]">{{ $evento['descripcion'] }}</p></div>
                            <div class="flex items-center gap-2 sm:justify-end"><x-portal.status-badge :status="$evento['estado']" /><span class="rounded-full px-3 py-1 text-[10px] font-bold {{ $hoy ? 'bg-[#D8F7CB] text-[#0E6B54]' : ($pasado ? 'bg-slate-100 text-slate-600' : 'bg-[#E4EBFF] text-[#4B6BC8]') }}">{{ $hoy ? 'Hoy' : ($pasado ? 'Completado' : 'Programado') }}</span></div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
