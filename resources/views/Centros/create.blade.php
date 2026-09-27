@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Nuevo Centro')

@section('contenido')
    <div class="space-y-8">
        {{-- ENCABEZADO --}}
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 md:p-8 shadow-[0_20px_45px_rgba(15,40,53,0.08)]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>
            <div class="relative z-10 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Gestión institucional</p>
                    <h1 class="mt-3 text-3xl md:text-4xl font-black text-[#0A2334] leading-tight">
                        Registrar nuevo centro
                    </h1>
                    <p class="mt-3 max-w-2xl text-sm md:text-base text-[#3b5d6e] leading-relaxed">
                        Completa la información del centro de formación para agregarlo al sistema.
                    </p>
                </div>

                <a href="{{ route('centros.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#C7DCE2] bg-white/70 px-5 py-3 text-sm font-semibold text-[#0A2334] transition-colors hover:bg-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                    Volver al listado
                </a>
            </div>
        </section>

        {{-- FORMULARIO --}}
        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 md:p-8 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
            <div class="mb-6 flex items-center gap-3 pb-4 border-b border-[#E3ECEF]">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#D8F7CB] text-[#0E6B54] shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.8" d="M4 20h16M5 20V8.5L12 4l7 4.5V20M9 20v-5h6v5M8 10h.01M12 10h.01M16 10h.01"/></svg>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-[#0A2334]">Datos del centro</h2>
                    <p class="text-xs text-[#5F7785]">Los campos marcados con * son obligatorios.</p>
                </div>
            </div>

            <form action="{{ route('centros.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1.5 md:col-span-1">
                        <label for="nombre" class="block text-xs font-bold text-[#0A2334] uppercase tracking-wider">
                            Nombre del centro <span class="text-[#0E6B54]">*</span>
                        </label>
                        <input
                            type="text"
                            id="nombre"
                            name="nombre"
                            value="{{ old('nombre') }}"
                            required
                            placeholder="Ej. Centro de Comercio y Servicios"
                            class="w-full px-4 py-3 bg-white border @error('nombre') border-rose-400 ring-1 ring-rose-300 @else border-[#D8E6EB] focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54] @enderror rounded-xl text-sm text-[#0A2334] placeholder-[#9FB2BC] outline-none transition-all duration-200"
                        >
                        @error('nombre')
                            <p class="text-xs text-rose-500 font-medium pt-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5 md:col-span-1">
                        <label for="direccion" class="block text-xs font-bold text-[#0A2334] uppercase tracking-wider">
                            Dirección <span class="text-[#0E6B54]">*</span>
                        </label>
                        <input
                            type="text"
                            id="direccion"
                            name="direccion"
                            value="{{ old('direccion') }}"
                            required
                            placeholder="Ej. Calle 52 # 13 - 65, Bogotá"
                            class="w-full px-4 py-3 bg-white border @error('direccion') border-rose-400 ring-1 ring-rose-300 @else border-[#D8E6EB] focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54] @enderror rounded-xl text-sm text-[#0A2334] placeholder-[#9FB2BC] outline-none transition-all duration-200"
                        >
                        @error('direccion')
                            <p class="text-xs text-rose-500 font-medium pt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-4 border-t border-[#E3ECEF]">
                    <a href="{{ route('centros.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl border border-[#C7DCE2] bg-white px-5 py-3 text-sm font-semibold text-[#0A2334] transition-colors hover:bg-[#F0F5F7]">
                        Cancelar
                    </a>
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-[#8AFD5D] px-6 py-3 text-sm font-extrabold text-[#001E30] shadow-lg shadow-[#8AFD5D]/20 transition-transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        Guardar centro
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection
