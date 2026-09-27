@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Detalle del Centro')

@section('contenido')
    <div class="space-y-8">
        {{-- ENCABEZADO --}}
        <section class="rounded-[30px] border border-[#D8E6EB] bg-gradient-to-r from-[#EAF6F4] via-[#F4F9FB] to-[#F0F5FF] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.08)] md:p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-5">
                    <div class="flex h-20 w-20 items-center justify-center overflow-hidden rounded-2xl border border-[#D8E6EB] bg-[#0E6B54] text-2xl font-black text-white shadow-sm shrink-0">
                        {{ strtoupper(substr($centro->nombre, 0, 1)) }}
                    </div>

                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#1B5E6A]">Centro de formación</p>
                        <h1 class="mt-2 text-3xl font-black text-[#0A2334]">
                            {{ $centro->nombre }}
                        </h1>
                        <p class="mt-1 text-sm text-[#5F7785]">
                            {{ $centro->direccion }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('centros.edit', $centro->id) }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30] shadow-lg shadow-[#8AFD5D]/20 transition-transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                        Editar centro
                    </a>
                    <a href="{{ route('centros.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#C7DCE2] bg-white/70 px-5 py-3 text-sm font-semibold text-[#0A2334] transition-colors hover:bg-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                        Volver al listado
                    </a>
                </div>
            </div>
        </section>

        {{-- RESUMEN --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#4b6473]">ID del centro</p>
                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                </div>
                <p class="mt-5 text-3xl font-black text-[#0A2334]">#{{ $centro->id }}</p>
                <p class="mt-2 text-xs text-[#5F7785]">Identificador único del registro</p>
            </div>

            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#4b6473]">Áreas</p>
                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6.75A2.75 2.75 0 016.75 4h10.5A2.75 2.75 0 0120 6.75v10.5A2.75 2.75 0 0117.25 20H6.75A2.75 2.75 0 014 17.25V6.75zm4.75 0v10.5m10.5-10.5v10.5"/></svg>
                    </span>
                </div>
                <p class="mt-5 text-3xl font-black text-[#0A2334]">{{ $centro->areas()->count() }}</p>
                <p class="mt-2 text-xs text-[#5F7785]">Áreas vinculadas a este centro</p>
            </div>

            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#4b6473]">Ambientes</p>
                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 19V7l8-4 8 4v12M4 19h16M8 11h2m4 0h2M8 15h2m4 0h2"/></svg>
                    </span>
                </div>
                <p class="mt-5 text-3xl font-black text-[#0A2334]">{{ $centro->environments()->count() }}</p>
                <p class="mt-2 text-xs text-[#5F7785]">Ambientes registrados en este centro</p>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
            {{-- INFORMACIÓN GENERAL --}}
            <div class="rounded-[28px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="mb-5 flex items-center justify-between">
                    <h2 class="text-xl font-extrabold text-[#0A2334]">Información general</h2>
                    <span class="rounded-full bg-[#D8F7CB] px-3 py-1 text-[10px] font-bold uppercase tracking-[0.22em] text-[#0E6B54]">Centro</span>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Nombre</p>
                        <p class="mt-2 text-base font-bold text-[#0A2334]">{{ $centro->nombre }}</p>
                    </div>

                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Dirección</p>
                        <p class="mt-2 text-base font-bold text-[#0A2334]">{{ $centro->direccion }}</p>
                    </div>

                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Registrado el</p>
                        <p class="mt-2 text-base font-bold text-[#0A2334]">{{ $centro->created_at?->translatedFormat('d \d\e F \d\e Y') }}</p>
                    </div>

                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Última actualización</p>
                        <p class="mt-2 text-base font-bold text-[#0A2334]">{{ $centro->updated_at?->translatedFormat('d \d\e F \d\e Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- ACCIONES --}}
            <div class="rounded-[28px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <h2 class="text-xl font-extrabold text-[#0A2334]">Acciones</h2>
                <p class="mt-2 text-sm text-[#5F7785]">Gestiona este registro desde aquí.</p>

                <div class="mt-6 space-y-3">
                    <a href="{{ route('centros.edit', $centro->id) }}" class="flex items-center justify-between rounded-2xl border border-[#D8E6EB] bg-white p-4 transition-all hover:border-[#8AFD5D]/50 hover:bg-[#F4FFF1]">
                        <span class="text-sm font-bold text-[#0A2334]">Editar información</span>
                        <svg class="w-4 h-4 text-[#5F7785]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </a>

                    <form action="{{ route('centros.destroy', $centro->id) }}" method="POST"
                          onsubmit="return confirm('¿Estás seguro de eliminar el centro {{ addslashes($centro->nombre) }}? Esta acción no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex w-full items-center justify-between rounded-2xl border border-rose-200 bg-white p-4 transition-all hover:bg-rose-50">
                            <span class="text-sm font-bold text-rose-500">Eliminar centro</span>
                            <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                        </button>
                    </form>
                </div>

                <div class="mt-8 rounded-2xl border border-[#CBE4D5] bg-[#EAFBF0] p-4">
                    <p class="text-xs uppercase tracking-[0.24em] text-[#0E6B54]">Nota</p>
                    <p class="mt-2 text-sm text-[#466371]">Al eliminar un centro se eliminarán en cascada sus áreas y ambientes asociados.</p>
                </div>
            </div>
        </section>
    </div>
@endsection
