@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Centros de Formación')

@section('contenido')
    <div class="space-y-8">
        {{-- ENCABEZADO --}}
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 md:p-8 shadow-[0_20px_45px_rgba(15,40,53,0.08)]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>
            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Gestión institucional</p>
                    <h1 class="mt-3 text-3xl md:text-4xl font-black text-[#0A2334] leading-tight">
                        Centros de Formación
                    </h1>
                    <p class="mt-3 max-w-2xl text-sm md:text-base text-[#3b5d6e] leading-relaxed">
                        Administra las sedes registradas en el sistema: crea nuevos centros, edita su información o consulta su detalle.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('centros.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30] shadow-lg shadow-[#8AFD5D]/20 transition-transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Nuevo centro
                    </a>
                </div>
            </div>
        </section>

        {{-- ALERTAS --}}
        @if (session('success'))
            <div class="rounded-2xl border border-[#BFE6B1] bg-[#EAFBF0] p-4 text-sm font-semibold text-[#0E6B54]">
                {{ session('success') }}
            </div>
        @endif

        {{-- RESUMEN --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#4b6473]">Total Centros</p>
                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.8" d="M4 20h16M5 20V8.5L12 4l7 4.5V20M9 20v-5h6v5M8 10h.01M12 10h.01M16 10h.01"/></svg>
                    </span>
                </div>
                <p class="mt-5 text-3xl font-black text-[#0A2334]">{{ $centros->count() }}</p>
                <p class="mt-2 text-xs text-[#5F7785]">Centros registrados en el sistema</p>
            </div>
        </section>

        {{-- TABLA --}}
        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Listado</p>
                    <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Todos los centros</h2>
                </div>
            </div>

            @if($centros->isEmpty())
                <div class="rounded-2xl border border-dashed border-[#D8E6EB] bg-white p-10 text-center">
                    <p class="text-sm font-semibold text-[#5F7785]">Aún no hay centros registrados.</p>
                    <a href="{{ route('centros.create') }}" class="mt-4 inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-5 py-2.5 text-sm font-extrabold text-[#001E30] shadow-md shadow-[#8AFD5D]/20 transition-transform hover:-translate-y-0.5">
                        Crear el primer centro
                    </a>
                </div>
            @else
                <div class="overflow-x-auto rounded-2xl border border-[#D8E6EB]">
                    <table class="min-w-full divide-y divide-[#D8E6EB]">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Nombre</th>
                                <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Dirección</th>
                                <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Registrado</th>
                                <th class="px-5 py-3.5 text-right text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EAF1F3] bg-[#F7FBFC]">
                            @foreach ($centros as $centro)
                                <tr class="hover:bg-white transition-colors duration-150">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#D8F7CB] text-[#0E6B54] font-black text-sm">
                                                {{ strtoupper(substr($centro->nombre, 0, 1)) }}
                                            </span>
                                            <span class="text-sm font-bold text-[#0A2334]">{{ $centro->nombre }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-sm text-[#456073]">{{ $centro->direccion }}</td>
                                    <td class="px-5 py-4 text-sm text-[#5F7785]">{{ $centro->created_at?->translatedFormat('d M Y') }}</td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('centros.show', $centro->id) }}" title="Ver detalle"
                                               class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#D8E6EB] bg-white text-[#0E6B54] hover:bg-[#EAFBF0] hover:border-[#BFE6B1] transition-all duration-150">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            </a>
                                            <a href="{{ route('centros.edit', $centro->id) }}" title="Editar"
                                               class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#D8E6EB] bg-white text-[#1B5E6A] hover:bg-[#F0F7FB] hover:border-[#BBD9E6] transition-all duration-150">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                            </a>
                                            <form action="{{ route('centros.destroy', $centro->id) }}" method="POST"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar el centro {{ addslashes($centro->nombre) }}? Esta acción no se puede deshacer.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Eliminar"
                                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-rose-200 bg-white text-rose-500 hover:bg-rose-50 hover:border-rose-300 transition-all duration-150">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
@endsection
