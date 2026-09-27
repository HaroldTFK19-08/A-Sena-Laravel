@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Inscripciones')

@section('contenido')
    <div class="space-y-8">
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#EAF5F4] via-[#F1F8F7] to-[#E9F0F7] p-6 md:p-8 shadow-[0_20px_45px_rgba(15,40,53,0.08)]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>
            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Admisión</p>
                    <h1 class="mt-3 text-3xl md:text-4xl font-black text-[#0A2334] leading-tight">Inscripciones</h1>
                    <p class="mt-3 max-w-2xl text-sm md:text-base text-[#3b5d6e] leading-relaxed">
                        Consulta, filtra y da seguimiento a las inscripciones de aspirantes a las ofertas de formación.
                    </p>
                </div>
            </div>
        </section>

        @if (session('success'))
            <div class="p-4 rounded-2xl bg-[#D8F7CB] text-[#0E6B54] border border-[#BCE6B0] text-sm font-semibold flex items-center shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-2xl bg-red-50 text-red-600 border border-red-200 text-sm font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <section class="grid grid-cols-2 gap-4 md:grid-cols-3 xl:grid-cols-6">
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-4 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#4b6473]">Total</p>
                <p class="mt-3 text-2xl font-black text-[#0A2334]">{{ $totales['total'] }}</p>
            </div>
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-4 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#4b6473]">Activas</p>
                <p class="mt-3 text-2xl font-black text-[#0E6B54]">{{ $totales['activas'] }}</p>
            </div>
            @foreach ($porEstado as $estado => $cantidad)
                <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-4 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#4b6473] truncate" title="{{ $estado }}">{{ $estado }}</p>
                    <p class="mt-3 text-2xl font-black text-[#0A2334]">{{ $cantidad }}</p>
                </div>
            @endforeach
        </section>

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
            <form method="GET" action="{{ route('inscripciones.index') }}" class="mb-8 overflow-hidden rounded-[24px] border border-[#D8E6EB] bg-white">
                <div class="border-b border-[#EAF1F3] bg-[#F8FBFC] px-5 py-4">
                    <h3 class="text-sm font-extrabold text-[#0A2334]">Buscar y filtrar inscripciones</h3>
                    <p class="text-xs text-[#78909C]">Encuentra inscripciones por aspirante, oferta o estado.</p>
                </div>
                <div class="grid grid-cols-1 gap-5 p-5 lg:grid-cols-[minmax(0,1fr)_220px_220px_auto] lg:items-end">
                    <div class="flex flex-col gap-2">
                        <label class="ml-1 text-xs font-bold uppercase tracking-[0.12em] text-[#5F7785]">Buscar aspirante</label>
                        <input type="search" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre, correo o identificación"
                            class="h-12 w-full rounded-2xl border border-[#D8E6EB] bg-[#F9FBFC] px-4 text-sm outline-none focus:border-[#8AFD5D] focus:ring-4 focus:ring-[#8AFD5D]/10">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="ml-1 text-xs font-bold uppercase tracking-[0.12em] text-[#5F7785]">Oferta</label>
                        <select name="oferta" class="h-12 w-full rounded-2xl border border-[#D8E6EB] bg-[#F9FBFC] px-4 text-sm outline-none focus:border-[#8AFD5D]">
                            <option value="">Todas</option>
                            @foreach ($ofertas as $oferta)
                                <option value="{{ $oferta->id }}" @selected(request('oferta') == $oferta->id)>
                                    {{ $oferta->program?->nombre ?? 'Oferta '.$oferta->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="ml-1 text-xs font-bold uppercase tracking-[0.12em] text-[#5F7785]">Estado</label>
                        <select name="estado" class="h-12 w-full rounded-2xl border border-[#D8E6EB] bg-[#F9FBFC] px-4 text-sm outline-none focus:border-[#8AFD5D]">
                            <option value="">Todos</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado }}" @selected(request('estado') === $estado)>{{ $estado }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="h-12 rounded-2xl bg-[#0E6B54] px-5 text-sm font-bold text-white hover:bg-[#0a5a46]">Filtrar</button>
                </div>
            </form>

            @if ($inscripciones->isEmpty())
                <div class="rounded-2xl border border-dashed border-[#D8E6EB] bg-white p-10 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF6F4] text-[#0E6B54]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="mt-4 font-bold text-[#0A2334]">No hay inscripciones</p>
                    <p class="mt-1 text-sm text-[#5F7785]">No se encontraron registros con los filtros actuales.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="text-sm text-[#4b6473]">
                            <tr class="border-b border-[#D8E6EB]">
                                <th class="py-4 px-4 font-semibold uppercase tracking-wider">Aspirante</th>
                                <th class="py-4 px-4 font-semibold uppercase tracking-wider">Oferta</th>
                                <th class="py-4 px-4 font-semibold uppercase tracking-wider">Fecha</th>
                                <th class="py-4 px-4 font-semibold uppercase tracking-wider">Estado</th>
                                <th class="py-4 px-4 font-semibold uppercase tracking-wider text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-[#0A2334]">
                            @foreach ($inscripciones as $inscripcion)
                                <tr class="border-b border-[#D8E6EB]/50 hover:bg-[#F1F8F7]">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#0E6B54] text-xs font-black text-white">
                                                {{ strtoupper(substr($inscripcion->aspirant?->user?->nombre_1 ?? 'A', 0, 1)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="truncate font-semibold">{{ $inscripcion->aspirant?->user?->nombre_completo ?? 'Sin usuario' }}</p>
                                                <p class="truncate text-xs text-[#5F7785]">{{ $inscripcion->aspirant?->user?->identificacion }} · {{ $inscripcion->aspirant?->user?->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">{{ $inscripcion->offer?->program?->nombre ?? 'Oferta '.$inscripcion->offer_id }}</td>
                                    <td class="py-4 px-4">{{ $inscripcion->Fecha_inscripcion?->format('d/m/Y H:i') }}</td>
                                    <td class="py-4 px-4">@include('Inscripciones.partials.estado', ['estado' => $inscripcion->estado])</td>
                                    <td class="py-4 px-4 text-right space-x-2">
                                        <a href="{{ route('inscripciones.show', $inscripcion) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-white border border-[#D8E6EB] text-xs font-semibold text-[#4b6473] hover:bg-[#F1F8F7]">Ver</a>
                                        <a href="{{ route('inscripciones.edit', $inscripcion) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-white border border-[#D8E6EB] text-xs font-semibold text-[#4b6473] hover:bg-[#F1F8F7]">Editar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $inscripciones->onEachSide(1)->links() }}</div>
            @endif
        </section>
    </div>
@endsection
