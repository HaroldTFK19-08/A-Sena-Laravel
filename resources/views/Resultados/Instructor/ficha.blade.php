@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Aprendices de la ficha')

@section('contenido')
    <div class="space-y-8">
        <section class="rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 md:p-8">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Ficha {{ $ficha->codigo }}</p>
            <h1 class="mt-3 text-3xl font-black text-[#0A2334]">{{ $ficha->program?->nombre }}</h1>
            <a href="{{ route('instructor.resultados.index') }}" class="mt-4 inline-flex text-sm font-semibold text-[#0E6B54]">Volver a resultados</a>
        </section>

        @if (session('success'))
            <div class="p-4 rounded-2xl bg-[#D8F7CB] text-[#0E6B54] border border-[#BCE6B0] text-sm font-semibold">{{ session('success') }}</div>
        @endif

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6">
            <h2 class="text-xl font-extrabold text-[#0A2334]">Calificar por competencia</h2>
            @if ($competencias->isEmpty())
                <p class="mt-4 text-sm text-[#5F7785]">No hay competencias asignadas para calificar.</p>
            @else
                <div class="mt-5 flex flex-wrap gap-3">
                    @foreach ($competencias as $competencia)
                        <a href="{{ route('instructor.resultados.calificar', [$ficha, $competencia]) }}" class="rounded-xl bg-[#0E6B54] px-4 py-2 text-xs font-bold text-white">
                            Calificar {{ $competencia->nombre }}
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6">
            <h2 class="text-xl font-extrabold text-[#0A2334]">Aprendices</h2>
            @if ($ficha->apprentices->isEmpty())
                <p class="mt-4 text-sm text-[#5F7785]">Esta ficha no tiene aprendices registrados.</p>
            @else
                <div class="mt-4 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="text-sm text-[#4b6473]">
                            <tr class="border-b border-[#D8E6EB]">
                                <th class="py-3 px-4">Aprendiz</th>
                                <th class="py-3 px-4">Identificación</th>
                                <th class="py-3 px-4">Correo</th>
                                <th class="py-3 px-4">Aprobados</th>
                                <th class="py-3 px-4">Reprobados</th>
                                <th class="py-3 px-4">Pendientes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ficha->apprentices as $aprendiz)
                                <tr class="border-b border-[#D8E6EB]/50">
                                    <td class="py-3 px-4 font-semibold">{{ $aprendiz->user?->nombre_completo }}</td>
                                    <td class="py-3 px-4">{{ $aprendiz->user?->identificacion }}</td>
                                    <td class="py-3 px-4">{{ $aprendiz->user?->email }}</td>
                                    <td class="py-3 px-4"><span class="font-bold text-[#0E6B54]">{{ $aprendiz->grades->where('estado_resultado', 'Aprobado')->count() }}</span></td>
                                    <td class="py-3 px-4"><span class="font-bold text-red-600">{{ $aprendiz->grades->where('estado_resultado', 'Reprobado')->count() }}</span></td>
                                    <td class="py-3 px-4"><span class="font-bold text-amber-600">{{ $aprendiz->grades->where('estado_resultado', 'Pendiente')->count() }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
@endsection
