@php
    $editing = isset($noticia);
@endphp

<form action="{{ $editing ? route('noticias.update', $noticia) : route('noticias.store') }}" 
      method="POST" 
      enctype="multipart/form-data" 
      class="space-y-6">
    @csrf
    @if ($editing)
        @method('PUT')
    @endif

    <div class="grid gap-5 md:grid-cols-2">
        {{-- Título --}}
        <div class="space-y-1.5 md:col-span-2">
            <label for="titulo" class="block text-xs font-bold uppercase tracking-wider text-[#0A2334]">
                Título *
            </label>
            <input id="titulo" 
                   name="titulo" 
                   type="text" 
                   value="{{ old('titulo', $noticia->titulo ?? '') }}" 
                   maxlength="255" 
                   required 
                   placeholder="Ej. Nueva convocatoria de formación" 
                   class="w-full rounded-xl border bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition @error('titulo') border-rose-400 ring-1 ring-rose-300 @else border-[#D8E6EB] focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54] @enderror">
            @error('titulo') 
                <p class="pt-0.5 text-xs font-medium text-rose-500">{{ $message }}</p> 
            @enderror
        </div>

        {{-- Centro de Formación --}}
        <div class="space-y-1.5">
            <label for="trainingcenter_id" class="block text-xs font-bold uppercase tracking-wider text-[#0A2334]">
                Centro de formación *
            </label>
            <select id="trainingcenter_id" 
                    name="trainingcenter_id" 
                    required 
                    class="w-full rounded-xl border border-[#D8E6EB] bg-white px-4 py-3 text-sm text-[#0A2334] outline-none focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54]">
                <option value="">Selecciona un centro</option>
                @foreach ($centros as $centro)
                    <option value="{{ $centro->id }}" @selected((string) old('trainingcenter_id', $noticia->trainingcenter_id ?? '') === (string) $centro->id)>
                        {{ $centro->nombre }}
                    </option>
                @endforeach
            </select>
            @error('trainingcenter_id') 
                <p class="pt-0.5 text-xs font-medium text-rose-500">{{ $message }}</p> 
            @enderror
        </div>

        {{-- Estado --}}
        <div class="space-y-1.5">
            <label for="estado" class="block text-xs font-bold uppercase tracking-wider text-[#0A2334]">
                Estado
            </label>
            <select id="estado" 
                    name="estado" 
                    class="w-full rounded-xl border border-[#D8E6EB] bg-white px-4 py-3 text-sm text-[#0A2334] outline-none focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54]">
                @foreach (['Creado', 'Pendiente', 'Publicado'] as $estado)
                    <option value="{{ $estado }}" @selected(old('estado', $noticia->estado ?? 'Creado') === $estado)>
                        {{ $estado }}
                    </option>
                @endforeach
            </select>
            @error('estado') 
                <p class="pt-0.5 text-xs font-medium text-rose-500">{{ $message }}</p> 
            @enderror
        </div>

        {{-- Descripción --}}
        <div class="space-y-1.5 md:col-span-2">
            <label for="descripcion" class="block text-xs font-bold uppercase tracking-wider text-[#0A2334]">
                Descripción *
            </label>
            <textarea id="descripcion" 
                      name="descripcion" 
                      rows="4" 
                      required 
                      placeholder="Escribe un resumen breve de la noticia" 
                      class="w-full resize-y rounded-xl border bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition @error('descripcion') border-rose-400 ring-1 ring-rose-300 @else border-[#D8E6EB] focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54] @enderror">{{ old('descripcion', $noticia->descripcion ?? '') }}</textarea>
            @error('descripcion') 
                <p class="pt-0.5 text-xs font-medium text-rose-500">{{ $message }}</p> 
            @enderror
        </div>

        {{-- Imagen --}}
        <div class="space-y-1.5 md:col-span-2">
            <label for="imagen" class="block text-xs font-bold uppercase tracking-wider text-[#0A2334]">
                Imagen
            </label>
            <input id="imagen" 
                   name="imagen" 
                   type="file" 
                   accept="image/png,image/jpeg,image/webp" 
                   class="block w-full rounded-xl border border-[#D8E6EB] bg-white px-4 py-3 text-sm text-[#456073] file:mr-4 file:rounded-lg file:border-0 file:bg-[#EAF6F4] file:px-3 file:py-2 file:text-xs file:font-bold file:text-[#0E6B54]">
            <p class="text-xs text-[#78909C]">PNG, JPG o WEBP. Máximo 2 MB.</p>
            @error('imagen') 
                <p class="pt-0.5 text-xs font-medium text-rose-500">{{ $message }}</p> 
            @enderror
            @if ($editing && $noticia->imagen)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $noticia->imagen) }}" 
                            alt="Imagen actual" 
                            class="h-28 w-48 rounded-xl object-cover border border-[#D8E6EB]">
                </div>
            @endif
        </div>
    </div>

    {{-- Botones de Acción --}}
    <div class="flex flex-col justify-end gap-3 border-t border-[#E3ECEF] pt-5 sm:flex-row">
        <a href="{{ route('noticias.index') }}" 
           class="inline-flex items-center justify-center rounded-xl border border-[#C7DCE2] bg-white px-5 py-3 text-sm font-semibold text-[#0A2334] transition hover:bg-[#F0F5F7]">
            Cancelar
        </a>
        <button type="submit" 
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#8AFD5D] px-6 py-3 text-sm font-extrabold text-[#001E30] shadow-lg shadow-[#8AFD5D]/20 transition-transform hover:-translate-y-0.5">
            {{ $editing ? 'Guardar cambios' : 'Crear Noticia' }}
        </button>
    </div>
</form>