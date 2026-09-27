@extends('Layouts.Usuarios.AppAdmin')
@section('titulo', 'Detalle de ficha')
@section('contenido')
    <div class="space-y-8">
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#EAF5F4] via-[#F1F8F7] to-[#E9F0F7] p-6 md:p-8 shadow-[0_20px_45px_rgba(15,40,53,0.08)]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>
            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Detalles de Formación</p>
                    <h1 class="mt-3 text-3xl md:text-4xl font-black text-[#0A2334] leading-tight">
                        Ficha {{ $ficha->codigo }}
                    </h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('fichas.index') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-white text-[#0A2334] font-bold transition-all border border-[#D8E6EB] hover:bg-[#F1F8F7] shadow-sm">
                        Volver
                    </a>
                    <a href="{{ route('fichas.edit', $ficha) }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-[#0E6B54] text-white font-bold transition-all hover:bg-[#0a5a46] shadow-lg hover:shadow-[#0e6b54]/30">
                        Editar Ficha
                    </a>
                </div>
            </div>
        </section>

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-8 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-[#5F7785] mb-1">Programa de Formación</p>
                        <p class="text-lg font-bold text-[#0A2334]">{{ $ficha->program?->nombre ?? 'No asignado' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-[#5F7785] mb-1">Capacidad de Aprendices</p>
                        <p class="text-lg font-bold text-[#0A2334]">{{ $ficha->capacidad_aprendices }} estudiantes</p>
                    </div>
                </div>
                <div class="space-y-6">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-[#5F7785] mb-2">Instructores Asignados</p>
                        <div class="flex flex-wrap gap-2">
                            @forelse($ficha->teachers as $teacher)
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#D8F7CB] text-[#0E6B54] text-xs font-bold border border-[#BCE6B0]">
                                    {{ $teacher->user?->nombre_1 ?? 'Instructor' }}
                                </span>
                            @empty
                                <span class="text-sm text-[#5F7785] italic">Ningún instructor asignada actualmente.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-8 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
            <div class="mb-6">
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Estudiantes</p>
                <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Aprendices en esta Ficha</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="text-sm text-[#4b6473]">
                        <tr class="border-b border-[#D8E6EB]">
                            <th class="py-4 px-4 font-semibold uppercase tracking-wider">Aprendiz</th>
                            <th class="py-4 px-4 font-semibold uppercase tracking-wider">Identificación</th>
                            <th class="py-4 px-4 font-semibold uppercase tracking-wider text-right">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-[#0A2334]">
                        @forelse($ficha->apprentices as $apprentice)
                            <tr class="border-b border-[#D8E6EB]/50 hover:bg-[#F1F8F7] transition-colors">
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#D8F7CB] text-[#0E6B54] font-bold mr-3 text-xs">A</span>
                                        <span class="font-medium">{{ $apprentice->user?->nombre_1 ?? 'S/N' }} {{ $apprentice->user?->apellido_1 ?? '' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">{{ $apprentice->user?->identificacion ?? 'N/A' }}</td>
                                <td class="py-4 px-4 text-right">
                                    <span class="rounded-full px-3 py-1 text-xs font-bold bg-emerald-100 text-emerald-700">Activo</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-10 text-center text-[#5F7785]">No hay aprendices asignados a esta ficha todavía.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
