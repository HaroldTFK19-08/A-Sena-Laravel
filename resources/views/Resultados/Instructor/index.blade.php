@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Resultados y calificaciones')

@section('contenido')
    <div class="space-y-8">
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#EAF5F4] via-[#F1F8F7] to-[#E9F0F7] p-6 md:p-8">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Docencia</p>
            <h1 class="mt-3 text-3xl font-black text-[#0A2334]">Resultados y calificaciones</h1>
            <p class="mt-3 text-sm text-[#3b5d6e]">Consulta las fichas y competencias asignadas para registrar las calificaciones de los aprendices.</p>
        </section>

        @if (session('success'))
            <div class="p-4 rounded-2xl bg-[#D8F7CB] text-[#0E6B54] border border-[#BCE6B0] text-sm font-semibold">{{ session('success') }}</div>
        @endif

        <section class="grid grid-cols-3 gap-4">
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-4">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#4b6473]">Fichas asignadas</p>
                <p class="mt-3 text-2xl font-black text-[#0A2334]">{{ $resumen['fichas'] }}</p>
            </div>
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-4">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#4b6473]">Aprendices</p>
                <p class="mt-3 text-2xl font-black text-[#0A2334]">{{ $resumen['aprendices'] }}</p>
            </div>
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-4">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#4b6473]">Competencias</p>
                <p class="mt-3 text-2xl font-black text-[#0A2334]">{{ $resumen['competencias'] }}</p>
            </div>
        </section>

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6">
            <h2 class="text-xl font-extrabold text-[#0A2334]">Fichas asignadas</h2>
            @if ($fichas->isEmpty())
                <div class="mt-4 rounded-2xl border border-dashed border-[#D8E6EB] bg-white p-8 text-center text-sm text-[#5F7785]">
                    No tienes fichas asignadas todavía.
                </div>
            @else
                <div class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-2">
                    @foreach ($fichas as $ficha)
                        <a href="{{ route('instructor.resultados.ficha', $ficha) }}" class="group rounded-2xl border border-[#D8E6EB] bg-white p-5 transition hover:-translate-y-0.5 hover:border-[#39A900]/50 hover:shadow-md">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#5F7785]">{{ $ficha->codigo }}</p>
                                    <h3 class="mt-2 text-lg font-extrabold text-[#0A2334]">{{ $ficha->program?->nombre }}</h3>
                                </div>
                                <span class="rounded-full bg-[#EAF6F4] px-3 py-1 text-[10px] font-bold uppercase tracking-[0.12em] text-[#0E6B54] shrink-0">{{ $ficha->apprentices_count }} aprendices</span>
                            </div>
                            <p class="mt-3 inline-flex items-center gap-1 text-xs font-bold text-[#39A900] group-hover:underline">
                                Ver y calificar
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                            </p>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6">
            <h2 class="text-xl font-extrabold text-[#0A2334]">Competencias asignadas</h2>
            @if ($competencias->isEmpty())
                <p class="mt-4 text-sm text-[#5F7785]">No tienes competencias asignadas.</p>
            @else
                <div class="mt-5 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="text-sm text-[#4b6473]">
                            <tr class="border-b border-[#D8E6EB]">
                                <th class="py-3 px-4">Competencia</th>
                                <th class="py-3 px-4">Resultados configurados</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($competencias as $competencia)
                                <tr class="border-b border-[#D8E6EB]/50">
                                    <td class="py-3 px-4 font-semibold">{{ $competencia->nombre }}</td>
                                    <td class="py-3 px-4">{{ $competencia->results_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
@endsection
