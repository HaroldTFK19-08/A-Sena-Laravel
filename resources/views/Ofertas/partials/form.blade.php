@php
    $editing = isset($oferta);
@endphp

{{-- Alerta de errores --}}
@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50/80 p-4 text-sm text-rose-700 backdrop-blur-sm">
        <div class="flex items-center gap-2 font-bold text-rose-800">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Revisa los datos ingresados</span>
        </div>
        <ul class="mt-2 list-disc space-y-1 pl-9 text-xs">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $editing ? route('ofertas.update', $oferta) : route('ofertas.store') }}" 
      method="POST" 
      enctype="multipart/form-data" 
      class="space-y-8">
    @csrf
    @if ($editing)
        @method('PUT')
    @endif

    {{-- Bloque 1: Información General --}}
    <div class="space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-wider text-[#78909C]">
            Información del Programa
        </h3>

        <div class="grid gap-5 md:grid-cols-3">
            {{-- Seleccionar Programa --}}
            <div class="space-y-1.5 md:col-span-2">
                <label for="program_id" class="block text-xs font-bold uppercase tracking-wider text-[#0A2334]">
                    Programa *
                </label>
                <select id="program_id" 
                        name="program_id" 
                        required 
                        class="w-full rounded-xl border bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition @error('program_id') border-rose-400 ring-1 ring-rose-300 @else border-[#D8E6EB] focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54] @enderror">
                    <option value="">Selecciona un programa</option>
                    @foreach ($programas as $programa)
                        <option value="{{ $programa->id }}" @selected((string) old('program_id', $oferta->program_id ?? '') === (string) $programa->id)>
                            {{ $programa->nombre }}{{ $programa->codigo_programa ? ' · ' . $programa->codigo_programa : '' }}
                        </option>
                    @endforeach
                </select>
                @error('program_id')
                    <p class="pt-0.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Capacidad --}}
            <div class="space-y-1.5">
                <label for="capacidad" class="block text-xs font-bold uppercase tracking-wider text-[#0A2334]">
                    Capacidad (Cupos) *
                </label>
                <input id="capacidad" 
                       name="capacidad" 
                       type="number" 
                       min="1" 
                       value="{{ old('capacidad', $oferta->capacidad ?? '') }}" 
                       required 
                       placeholder="Ej. 30"
                       class="w-full rounded-xl border bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition @error('capacidad') border-rose-400 ring-1 ring-rose-300 @else border-[#D8E6EB] focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54] @enderror">
                @error('capacidad')
                    <p class="pt-0.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Bloque 2: Cronograma del Proceso --}}
    <div class="space-y-4 pt-2">
        <h3 class="text-xs font-bold uppercase tracking-wider text-[#78909C]">
            Cronograma de la Convocatoria
        </h3>

        <div class="grid gap-5 sm:grid-cols-2 md:grid-cols-3">
            {{-- Fecha Lanzamiento --}}
            <div class="space-y-1.5">
                <label for="fecha_lanzamiento" class="block text-xs font-bold uppercase tracking-wider text-[#0A2334]">
                    Fecha de lanzamiento *
                </label>
                <input id="fecha_lanzamiento" 
                       name="fecha_lanzamiento" 
                       type="date" 
                       value="{{ old('fecha_lanzamiento', isset($oferta) && $oferta->fecha_lanzamiento ? $oferta->fecha_lanzamiento->format('Y-m-d') : '') }}" 
                       required 
                       class="w-full rounded-xl border border-[#D8E6EB] bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54]">
                @error('fecha_lanzamiento')
                    <p class="pt-0.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Inicio Convocatoria --}}
            <div class="space-y-1.5">
                <label for="fecha_convocatoria" class="block text-xs font-bold uppercase tracking-wider text-[#0A2334]">
                    Inicio de convocatoria *
                </label>
                <input id="fecha_convocatoria" 
                       name="fecha_convocatoria" 
                       type="date" 
                       value="{{ old('fecha_convocatoria', isset($oferta) && $oferta->fecha_convocatoria ? $oferta->fecha_convocatoria->format('Y-m-d') : '') }}" 
                       required 
                       class="w-full rounded-xl border border-[#D8E6EB] bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54]">
                @error('fecha_convocatoria')
                    <p class="pt-0.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Cierre Convocatoria --}}
            <div class="space-y-1.5">
                <label for="fecha_fin_convocatoria" class="block text-xs font-bold uppercase tracking-wider text-[#0A2334]">
                    Cierre de convocatoria *
                </label>
                <input id="fecha_fin_convocatoria" 
                       name="fecha_fin_convocatoria" 
                       type="date" 
                       value="{{ old('fecha_fin_convocatoria', isset($oferta) && $oferta->fecha_fin_convocatoria ? $oferta->fecha_fin_convocatoria->format('Y-m-d') : '') }}" 
                       required 
                       class="w-full rounded-xl border border-[#D8E6EB] bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54]">
                @error('fecha_fin_convocatoria')
                    <p class="pt-0.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Primera Prueba --}}
            <div class="space-y-1.5">
                <label for="fecha_primera_prueba" class="block text-xs font-bold uppercase tracking-wider text-[#0A2334]">
                    Primera prueba *
                </label>
                <input id="fecha_primera_prueba" 
                       name="fecha_primera_prueba" 
                       type="date" 
                       value="{{ old('fecha_primera_prueba', isset($oferta) && $oferta->fecha_primera_prueba ? $oferta->fecha_primera_prueba->format('Y-m-d') : '') }}" 
                       required 
                       class="w-full rounded-xl border border-[#D8E6EB] bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54]">
                @error('fecha_primera_prueba')
                    <p class="pt-0.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Segunda Prueba --}}
            <div class="space-y-1.5">
                <label for="fecha_segunda_prueba" class="block text-xs font-bold uppercase tracking-wider text-[#0A2334]">
                    Segunda prueba <span class="text-xs font-normal text-slate-400">(Opcional)</span>
                </label>
                <input id="fecha_segunda_prueba" 
                       name="fecha_segunda_prueba" 
                       type="date" 
                       value="{{ old('fecha_segunda_prueba', isset($oferta) && $oferta->fecha_segunda_prueba ? $oferta->fecha_segunda_prueba->format('Y-m-d') : '') }}" 
                       class="w-full rounded-xl border border-[#D8E6EB] bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54]">
                @error('fecha_segunda_prueba')
                    <p class="pt-0.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Seleccionados --}}
            <div class="space-y-1.5">
                <label for="fecha_seleccionados" class="block text-xs font-bold uppercase tracking-wider text-[#0A2334]">
                    Publicación seleccionados *
                </label>
                <input id="fecha_seleccionados" 
                       name="fecha_seleccionados" 
                       type="date" 
                       value="{{ old('fecha_seleccionados', isset($oferta) && $oferta->fecha_seleccionados ? $oferta->fecha_seleccionados->format('Y-m-d') : '') }}" 
                       required 
                       class="w-full rounded-xl border border-[#D8E6EB] bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54]">
                @error('fecha_seleccionados')
                    <p class="pt-0.5 text-xs font-medium text-rose-500">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Bloque 3: Multimedia --}}
    <div class="space-y-4 pt-2">
        <h3 class="text-xs font-bold uppercase tracking-wider text-[#78909C]">
            Imagen Promocional
        </h3>

        <div class="space-y-1.5">
            <input id="imagen" 
                   name="imagen" 
                   type="file" 
                   accept="image/png,image/jpeg,image/webp" 
                   class="block w-full rounded-xl border border-[#D8E6EB] bg-white px-4 py-3 text-sm text-[#456073] file:mr-4 file:rounded-lg file:border-0 file:bg-[#EAF6F4] file:px-3 file:py-2 file:text-xs file:font-bold file:text-[#0E6B54] hover:file:bg-[#d5eee9] transition">
            <p class="text-xs text-[#78909C]">PNG, JPG o WEBP. Tamaño máximo permitido: 2 MB.</p>
            @error('imagen')
                <p class="pt-0.5 text-xs font-medium text-rose-500">{{ $message }}</p>
            @enderror

            @if ($editing && $oferta->imagen)
                <div class="mt-3 flex items-center gap-4 rounded-xl border border-[#D8E6EB] p-3 bg-white w-fit">
                    <img src="{{ asset('storage/' . $oferta->imagen) }}" 
                         alt="Imagen actual" 
                         class="h-20 w-32 rounded-lg object-cover">
                    <span class="text-xs font-medium text-slate-500">Imagen actual precargada</span>
                </div>
            @endif
        </div>
    </div>

    {{-- Botones de Acción --}}
    <div class="flex flex-col justify-end gap-3 border-t border-[#E3ECEF] pt-6 sm:flex-row">
        <a href="{{ route('ofertas.index') }}" 
           class="inline-flex items-center justify-center rounded-xl border border-[#C7DCE2] bg-white px-5 py-3 text-sm font-semibold text-[#0A2334] transition hover:bg-[#F0F5F7]">
            Cancelar
        </a>
        <button type="submit" 
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#8AFD5D] px-6 py-3 text-sm font-extrabold text-[#001E30] shadow-lg shadow-[#8AFD5D]/20 transition-all hover:-translate-y-0.5 hover:bg-[#7be850]">
            {{ $editing ? 'Guardar cambios' : 'Crear oferta' }}
        </button>
    </div>
</form>