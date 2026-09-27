{{-- SECCIÓN: DATOS PERSONALES --}}
<div class="space-y-6 mx-5 my-5">

    <div class="flex items-center gap-3 pb-3 border-b border-white/10">
        <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-[#8AFD5D]/10 text-[#8AFD5D] ring-1 ring-[#8AFD5D]/20 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>

        <div>
            <h3 class="text-sm font-bold uppercase tracking-[0.18em] text-white">
                Información Personal
            </h3>
            <p class="text-[10px] text-slate-400 mt-0.5">
                Completa tus datos personales
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div class="space-y-1.5">
            <label for="nombre_1" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">
                Primer Nombre <span class="text-[#8AFD5D]">*</span>
            </label>
            <input
                type="text"
                id="nombre_1"
                name="nombre_1"
                value="{{ old('nombre_1') }}"
                required
                placeholder="Ej. Carlos"
                class="w-full px-3.5 py-2.5 bg-[#001E30]/80 border @error('nombre_1') border-rose-500/80 ring-1 ring-rose-500/40 @else border-white/10 focus:border-[#8AFD5D] focus:ring-1 focus:ring-[#8AFD5D] @enderror rounded-xl text-sm text-white placeholder-slate-500 outline-none transition-all duration-200"
            >
            @error('nombre_1')
                <p class="text-xs text-rose-400 flex items-center gap-1 font-medium pt-0.5">
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <label for="nombre_2" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">
                Segundo Nombre <span class="text-slate-500 text-[10px] font-normal lowercase">(opcional)</span>
            </label>
            <input
                type="text"
                id="nombre_2"
                name="nombre_2"
                value="{{ old('nombre_2') }}"
                placeholder="Ej. Alberto"
                class="w-full px-3.5 py-2.5 bg-[#001E30]/80 border @error('nombre_2') border-rose-500/80 ring-1 ring-rose-500/40 @else border-white/10 focus:border-[#8AFD5D] focus:ring-1 focus:ring-[#8AFD5D] @enderror rounded-xl text-sm text-white placeholder-slate-500 outline-none transition-all duration-200"
            >
        </div>

        <div class="space-y-1.5">
            <label for="apellido_1" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">
                Primer Apellido <span class="text-[#8AFD5D]">*</span>
            </label>
            <input
                type="text"
                id="apellido_1"
                name="apellido_1"
                value="{{ old('apellido_1') }}"
                required
                placeholder="Ej. Gómez"
                class="w-full px-3.5 py-2.5 bg-[#001E30]/80 border @error('apellido_1') border-rose-500/80 ring-1 ring-rose-500/40 @else border-white/10 focus:border-[#8AFD5D] focus:ring-1 focus:ring-[#8AFD5D] @enderror rounded-xl text-sm text-white placeholder-slate-500 outline-none transition-all duration-200"
            >
            @error('apellido_1')
                <p class="text-xs text-rose-400 flex items-center gap-1 font-medium pt-0.5">
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <label for="apellido_2" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">
                Segundo Apellido <span class="text-slate-500 text-[10px] font-normal lowercase">(opcional)</span>
            </label>
            <input
                type="text"
                id="apellido_2"
                name="apellido_2"
                value="{{ old('apellido_2') }}"
                placeholder="Ej. Ramírez"
                class="w-full px-3.5 py-2.5 bg-[#001E30]/80 border @error('apellido_2') border-rose-500/80 ring-1 ring-rose-500/40 @else border-white/10 focus:border-[#8AFD5D] focus:ring-1 focus:ring-[#8AFD5D] @enderror rounded-xl text-sm text-white placeholder-slate-500 outline-none transition-all duration-200"
            >
        </div>
    </div>

    <div class="space-y-1.5 pt-1">
        <label for="foto_perfil" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">
            Foto de perfil <span class="text-slate-500 text-[10px] font-normal lowercase">(opcional)</span>
        </label>

        <label
            for="foto_perfil"
            class="group relative flex items-center gap-4 w-full p-3.5 border border-dashed @error('foto_perfil') border-rose-500/70 bg-rose-500/5 @else border-white/10 bg-[#001E30]/40 hover:border-[#8AFD5D]/80 hover:bg-[#8AFD5D]/5 @enderror rounded-xl cursor-pointer transition-all duration-200"
        >
            <div class="relative shrink-0">
                <div
                    id="fotoIcono"
                    class="{{ isset($usuario) && $usuario->foto_perfil ? 'hidden' : 'flex' }} items-center justify-center w-12 h-12 rounded-full bg-[#8AFD5D]/10 text-[#8AFD5D] transition-transform duration-300 group-hover:scale-105"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-2.5M16.5 8.5L12 4m0 0L7.5 8.5M12 4v12"/>
                    </svg>
                </div>

                <img
                    id="previewFoto"
                    src="{{ isset($usuario) && $usuario->foto_perfil ? asset('storage/' . $usuario->foto_perfil) : '' }}"
                    alt="Vista previa"
                    class="{{ isset($usuario) && $usuario->foto_perfil ? '' : 'hidden' }} w-12 h-12 rounded-full object-cover border-2 border-[#8AFD5D]"
                >
            </div>

            <div class="flex-1 min-w-0">
                <p id="textoFoto" class="text-xs font-semibold text-white group-hover:text-[#8AFD5D] transition-colors duration-200 truncate">
                    {{ isset($usuario) && $usuario->foto_perfil ? 'Cambiar foto de perfil' : 'Haz clic para subir una foto' }}
                </p>
                <p id="subtextoFoto" class="text-[11px] text-slate-400 mt-0.5">
                    Formato PNG • Máximo 2 MB
                </p>
            </div>

            <span class="hidden sm:inline-flex px-3 py-1.5 text-xs font-semibold text-[#8AFD5D] bg-[#8AFD5D]/10 rounded-lg group-hover:bg-[#8AFD5D] group-hover:text-black transition-all duration-200 shrink-0">
                Examinar
            </span>

            <input type="file" id="foto_perfil" name="foto_perfil" accept="image/png" class="hidden">
        </label>

        @error('foto_perfil')
            <p class="text-xs text-rose-400 flex items-center gap-1 font-medium pt-1">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m0 3.75h.007M10.29 3.86 2.82 17.25A2 2 0 0 0 4.55 20.25h14.9a2 2 0 0 0 1.73-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/>
                </svg>
                <span>{{ $message }}</span>
            </p>
        @enderror
    </div>
</div>

<script>
    document.getElementById('foto_perfil')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('previewFoto');
        const icono = document.getElementById('fotoIcono');
        const texto = document.getElementById('textoFoto');
        const subtexto = document.getElementById('subtextoFoto');

        if (file) {
            if (file.type !== 'image/png') {
                alert('Por favor selecciona únicamente un archivo en formato PNG.');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                icono.classList.add('hidden');

                texto.textContent = file.name;
                texto.classList.add('text-[#8AFD5D]');
                subtexto.textContent = 'Archivo listo para subir';
            };
            reader.readAsDataURL(file);
        }
    });
</script>