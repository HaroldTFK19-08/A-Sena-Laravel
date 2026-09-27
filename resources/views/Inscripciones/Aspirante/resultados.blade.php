@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Resultados de admisión')

@section('contenido')
    <div class="space-y-8">
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#EAF5F4] via-[#F1F8F7] to-[#E9F0F7] p-6 md:p-8">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Mi proceso</p>
            <h1 class="mt-3 text-3xl font-black text-[#0A2334]">Resultados de admisión</h1>
            <p class="mt-3 text-sm text-[#3b5d6e]">Consulta el estado de cada inscripción: seleccionado, en proceso, rechazado o cancelado.</p>
        </section>

        <section class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-4">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#4b6473]">Seleccionadas</p>
                <p class="mt-3 text-2xl font-black text-[#0E6B54]">{{ $resumen['seleccionadas'] }}</p>
            </div>
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-4">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#4b6473]">En proceso</p>
                <p class="mt-3 text-2xl font-black text-amber-600">{{ $resumen['en_proceso'] }}</p>
            </div>
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-4">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#4b6473]">Rechazadas</p>
                <p class="mt-3 text-2xl font-black text-red-500">{{ $resumen['rechazadas'] }}</p>
            </div>
        </section>

        @if ($inscripciones->isEmpty())
            <div class="rounded-2xl border border-dashed border-[#D8E6EB] bg-white p-10 text-center text-sm text-[#5F7785]">
                Todavía no tienes resultados. Primero debes inscribirte a una oferta.
            </div>
        @else
            <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="text-sm text-[#4b6473]">
                            <tr class="border-b border-[#D8E6EB]">
                                <th class="py-4 px-4">Programa</th>
                                <th class="py-4 px-4">Fecha</th>
                                <th class="py-4 px-4">Resultado</th>
                                <th class="py-4 px-4 text-right">Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inscripciones as $inscripcion)
                                <tr class="border-b border-[#D8E6EB]/50">
                                    <td class="py-4 px-4 font-semibold">{{ $inscripcion->offer?->program?->nombre }}</td>
                                    <td class="py-4 px-4">{{ $inscripcion->Fecha_inscripcion?->format('d/m/Y') }}</td>
                                    <td class="py-4 px-4">@include('Inscripciones.partials.estado', ['estado' => $inscripcion->estado])</td>
                                    <td class="py-4 px-4 text-right">
                                        <a href="{{ route('aspirante.inscripciones.show', $inscripcion) }}" class="inline-flex rounded-lg border border-[#D8E6EB] bg-white px-3 py-1.5 text-xs font-semibold">Ver</a>
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
