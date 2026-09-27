@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Mis resultados')

@section('contenido')
    <div class="space-y-8">
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#EAF5F4] via-[#F1F8F7] to-[#E9F0F7] p-6 md:p-8">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Formación</p>
            <h1 class="mt-3 text-3xl font-black text-[#0A2334]">Mis resultados de aprendizaje</h1>
            <p class="mt-3 text-sm text-[#3b5d6e]">Consulta las calificaciones registradas por tus instructores.</p>
        </section>

        <section class="grid grid-cols-1 gap-5 md:grid-cols-4">
            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5">
                <p class="text-sm text-[#4b6473]">Total</p>
                <p class="mt-3 text-3xl font-black text-[#0A2334]">{{ $resumen['total'] }}</p>
            </div>
            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5">
                <p class="text-sm text-[#4b6473]">Aprobados</p>
                <p class="mt-3 text-3xl font-black text-[#0E6B54]">{{ $resumen['aprobados'] }}</p>
            </div>
            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5">
                <p class="text-sm text-[#4b6473]">Reprobados</p>
                <p class="mt-3 text-3xl font-black text-red-600">{{ $resumen['reprobados'] }}</p>
            </div>
            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5">
                <p class="text-sm text-[#4b6473]">Pendientes</p>
                <p class="mt-3 text-3xl font-black text-amber-600">{{ $resumen['pendientes'] }}</p>
            </div>
        </section>

        @if ($resumen['total'] > 0)
            @php
                $porcentajeAprobado = (int) round(($resumen['aprobados'] / $resumen['total']) * 100);
            @endphp
            <section class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5">
                <div class="flex items-center justify-between text-sm">
                    <p class="font-semibold text-[#0A2334]">Avance general</p>
                    <p class="font-bold text-[#0E6B54]">{{ $porcentajeAprobado }}% aprobado</p>
                </div>
                <div class="mt-2 h-2.5 w-full overflow-hidden rounded-full bg-[#EAF1F3]">
                    <div class="h-full rounded-full bg-[#39A900]" style="width: {{ $porcentajeAprobado }}%"></div>
                </div>
            </section>
        @endif

        @if ($calificaciones->isEmpty())
            <div class="rounded-2xl border border-dashed border-[#D8E6EB] bg-white p-10 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF6F4] text-[#0E6B54]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="mt-4 font-bold text-[#0A2334]">Aún sin calificaciones</p>
                <p class="mt-1 text-sm text-[#5F7785]">Todavía no hay calificaciones registradas para tu ficha.</p>
            </div>
        @else
            <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="text-sm text-[#4b6473]">
                            <tr class="border-b border-[#D8E6EB]">
                                <th class="py-4 px-4">Competencia</th>
                                <th class="py-4 px-4">Resultado</th>
                                <th class="py-4 px-4">Estado</th>
                                <th class="py-4 px-4">Instructor</th>
                                <th class="py-4 px-4">Comentarios</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($calificaciones as $calificacion)
                                <tr class="border-b border-[#D8E6EB]/50">
                                    <td class="py-4 px-4">{{ $calificacion->result?->competition?->nombre }}</td>
                                    <td class="py-4 px-4 font-semibold">{{ $calificacion->result?->nombre }}</td>
                                    <td class="py-4 px-4">@include('Inscripciones.partials.estado', ['estado' => $calificacion->estado_resultado])</td>
                                    <td class="py-4 px-4">{{ $calificacion->teacher?->user?->nombre_completo ?? '—' }}</td>
                                    <td class="py-4 px-4 text-sm text-[#5F7785]">{{ $calificacion->comentarios ?: '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $calificaciones->links() }}</div>
            </section>
        @endif
    </div>
@endsection
