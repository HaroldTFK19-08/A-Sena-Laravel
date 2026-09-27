@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Detalle de resultado')

@section('contenido')
    <div class="space-y-8">
        <section class="rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 md:p-8">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">{{ $resultado->codigo ?: 'Resultado' }}</p>
            <h1 class="mt-3 text-3xl font-black text-[#0A2334]">{{ $resultado->nombre }}</h1>
            <p class="mt-3 text-sm text-[#3B5D6E]">Competencia: {{ $resultado->competition?->nombre }}</p>
        </section>

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6">
            <p class="text-sm text-[#45616F]">{{ $resultado->descripcion ?: 'Sin descripción.' }}</p>
        </section>

        <section class="grid grid-cols-3 gap-4">
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-4">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#4b6473]">Aprobados</p>
                <p class="mt-3 text-2xl font-black text-[#0E6B54]">{{ $resumen['aprobados'] }}</p>
            </div>
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-4">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#4b6473]">Reprobados</p>
                <p class="mt-3 text-2xl font-black text-red-600">{{ $resumen['reprobados'] }}</p>
            </div>
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-4">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#4b6473]">Pendientes</p>
                <p class="mt-3 text-2xl font-black text-amber-600">{{ $resumen['pendientes'] }}</p>
            </div>
        </section>

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6">
            <h2 class="text-xl font-extrabold text-[#0A2334]">Calificaciones asociadas</h2>
            @if ($resultado->grades->isEmpty())
                <p class="mt-4 text-sm text-[#5F7785]">Todavía no hay calificaciones registradas para este resultado. Puede eliminarse con seguridad.</p>
            @else
                <div class="mt-4 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="text-sm text-[#4B6473]">
                            <tr class="border-b border-[#D8E6EB]">
                                <th class="py-3 px-4">Aprendiz</th>
                                <th class="py-3 px-4">Instructor</th>
                                <th class="py-3 px-4">Estado</th>
                                <th class="py-3 px-4">Comentarios</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resultado->grades as $calificacion)
                                <tr class="border-b border-[#D8E6EB]/50">
                                    <td class="py-3 px-4">{{ $calificacion->apprentice?->user?->nombre_completo }}</td>
                                    <td class="py-3 px-4">{{ $calificacion->teacher?->user?->nombre_completo ?? '—' }}</td>
                                    <td class="py-3 px-4">@include('Inscripciones.partials.estado', ['estado' => $calificacion->estado_resultado])</td>
                                    <td class="py-3 px-4 text-sm text-[#5F7785]">{{ $calificacion->comentarios ?: '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
@endsection
