@extends('Layouts.Usuarios.AppAdmin')
@section('titulo', 'Gestión de Fichas')
@section('contenido')
    <div class="space-y-8">
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#EAF5F4] via-[#F1F8F7] to-[#E9F0F7] p-6 md:p-8 shadow-[0_20px_45px_rgba(15,40,53,0.08)]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>
            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Administración</p>
                    <h1 class="mt-3 text-3xl md:text-4xl font-black text-[#0A2334] leading-tight">
                        Gestión de Fichas
                    </h1>
                    <p class="mt-3 max-w-2xl text-sm md:text-base text-[#3b5d6e] leading-relaxed">
                        Supervisa y organiza los grupos de formación y sus capacidades.
                    </p>
                </div>
                <a href="{{ route('fichas.create') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-[#0E6B54] text-white font-bold transition-all hover:bg-[#0a5a46] shadow-lg hover:shadow-[#0e6b54]/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nueva ficha
                </a>
            </div>
        </section>

        @if (session('success'))
            <div class="p-4 rounded-2xl bg-[#D8F7CB] text-[#0E6B54] border border-[#BCE6B0] text-sm font-semibold flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="text-sm text-[#4b6473]">
                        <tr class="border-b border-[#D8E6EB]">
                            <th class="py-4 px-4 font-semibold uppercase tracking-wider">Código</th>
                            <th class="py-4 px-4 font-semibold uppercase tracking-wider">Programa</th>
                            <th class="py-4 px-4 font-semibold uppercase tracking-wider">Instructores</th>
                            <th class="py-4 px-4 font-semibold uppercase tracking-wider">Capacidad</th>
                            <th class="py-4 px-4 font-semibold uppercase tracking-wider text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-[#0A2334]">
                        @forelse($fichas as $ficha)
                            <tr class="border-b border-[#D8E6EB]/50 hover:bg-[#F1F8F7] transition-colors">
                                <td class="py-4 px-4 font-bold">{{ $ficha->codigo }}</td>
                                <td class="py-4 px-4">{{ $ficha->program?->nombre }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($ficha->teachers as $teacher)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-[#D8F7CB] text-[#0E6B54] text-[10px] font-bold border border-[#BCE6B0]">
                                                {{ $teacher->user?->nombre_1 ?? 'Inst.' }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-4 px-4">{{ $ficha->capacidad_aprendices }}</td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('fichas.show', $ficha) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-white border border-[#D8E6EB] text-xs font-semibold text-[#4b6473] hover:bg-[#F1F8F7] transition-all">Ver</a>
                                        <a href="{{ route('fichas.edit', $ficha) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-white border border-[#D8E6EB] text-xs font-semibold text-[#4b6473] hover:bg-[#F1F8F7] transition-all">Editar</a>
                                        <form class="inline" method="POST" action="{{ route('fichas.destroy', $ficha) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-white border border-red-200 text-xs font-semibold text-red-500 hover:bg-red-50 transition-all" onclick="return confirm('¿Estás seguro de eliminar esta ficha?')">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-[#5F7785]">
                                    No hay fichas registradas actualmente.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
