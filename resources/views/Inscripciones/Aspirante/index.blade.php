@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Mis inscripciones')

@section('contenido')
    <div class="space-y-8">
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#EAF5F4] via-[#F1F8F7] to-[#E9F0F7] p-6 md:p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Mi proceso</p>
                    <h1 class="mt-3 text-3xl font-black text-[#0A2334]">Mis inscripciones</h1>
                    <p class="mt-3 text-sm text-[#3b5d6e]">Consulta el estado de tus solicitudes y gestiona las que todavía permiten cambios.</p>
                </div>
                <a href="{{ route('aspirante.ofertas.index') }}" class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30]">Ver ofertas</a>
            </div>
        </section>

        @if (session('success'))
            <div class="p-4 rounded-2xl bg-[#D8F7CB] text-[#0E6B54] border border-[#BCE6B0] text-sm font-semibold">{{ session('success') }}</div>
        @endif

        <section class="grid grid-cols-2 gap-4 md:grid-cols-4">
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-4">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#4b6473]">Total</p>
                <p class="mt-3 text-2xl font-black text-[#0A2334]">{{ $resumen['total'] }}</p>
            </div>
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-4">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#4b6473]">En proceso</p>
                <p class="mt-3 text-2xl font-black text-amber-600">{{ $resumen['en_proceso'] }}</p>
            </div>
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-4">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#4b6473]">Seleccionadas</p>
                <p class="mt-3 text-2xl font-black text-[#0E6B54]">{{ $resumen['seleccionadas'] }}</p>
            </div>
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-4">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#4b6473]">Canceladas/Rechazadas</p>
                <p class="mt-3 text-2xl font-black text-red-500">{{ $resumen['canceladas'] }}</p>
            </div>
        </section>

        @if ($inscripciones->isEmpty())
            <div class="rounded-2xl border border-dashed border-[#D8E6EB] bg-white p-10 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF6F4] text-[#0E6B54]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <p class="mt-4 font-bold text-[#0A2334]">Todavía no tienes inscripciones</p>
                <p class="mt-1 text-sm text-[#5F7785]">Explora las ofertas disponibles para comenzar.</p>
            </div>
        @else
            <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="text-sm text-[#4b6473]">
                            <tr class="border-b border-[#D8E6EB]">
                                <th class="py-4 px-4">Oferta</th>
                                <th class="py-4 px-4">Fecha</th>
                                <th class="py-4 px-4">Estado</th>
                                <th class="py-4 px-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inscripciones as $inscripcion)
                                <tr class="border-b border-[#D8E6EB]/50">
                                    <td class="py-4 px-4 font-semibold">{{ $inscripcion->offer?->program?->nombre }}</td>
                                    <td class="py-4 px-4">{{ $inscripcion->Fecha_inscripcion?->format('d/m/Y') }}</td>
                                    <td class="py-4 px-4">@include('Inscripciones.partials.estado', ['estado' => $inscripcion->estado])</td>
                                    <td class="py-4 px-4 text-right space-x-2">
                                        <a href="{{ route('aspirante.inscripciones.show', $inscripcion) }}" class="inline-flex rounded-lg border border-[#D8E6EB] bg-white px-3 py-1.5 text-xs font-semibold">Ver</a>
                                        @if ($inscripcion->permiteEdicion())
                                            <a href="{{ route('aspirante.inscripciones.edit', $inscripcion) }}" class="inline-flex rounded-lg border border-[#D8E6EB] bg-white px-3 py-1.5 text-xs font-semibold">Editar</a>
                                        @endif
                                        @if ($inscripcion->permiteCancelacion())
                                            <form class="inline" method="POST" action="{{ route('aspirante.inscripciones.cancelar', $inscripcion) }}" onsubmit="return confirm('¿Deseas cancelar esta inscripción?');">
                                                @csrf
                                                @method('PATCH')
                                                <button class="inline-flex rounded-lg border border-red-200 bg-white px-3 py-1.5 text-xs font-semibold text-red-500">Cancelar</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $inscripciones->links() }}</div>
            </section>
        @endif
    </div>
@endsection
