{{-- SECCIÓN: IDENTIFICACIÓN Y ROL --}}
<div class="space-y-6 mx-5 my-5">

    <div class="flex items-center gap-3 pb-3 border-b border-white/10">
        <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-[#8AFD5D]/10 text-[#8AFD5D] ring-1 ring-[#8AFD5D]/20 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
            </svg>
        </div>
        <div>
            <h3 class="text-sm font-bold uppercase tracking-[0.18em] text-white">
                Identificación y Rol
            </h3>
            <p class="text-[10px] text-slate-400 mt-0.5">
                Especifica tus datos institucionales
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div class="space-y-1.5">
            <label for="tipo_identificacion" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">
                Tipo de Documento <span class="text-[#8AFD5D]">*</span>
            </label>
            <div class="relative">
                <select
                    id="tipo_identificacion"
                    name="tipo_identificacion"
                    required
                    class="w-full px-3.5 py-2.5 bg-[#001E30]/80 border @error('tipo_identificacion') border-rose-500/80 ring-1 ring-rose-500/40 @else border-white/10 focus:border-[#8AFD5D] focus:ring-1 focus:ring-[#8AFD5D] @enderror rounded-xl text-sm text-white outline-none appearance-none transition-all duration-200 cursor-pointer pr-10"
                >
                    <option value="" disabled {{ old('tipo_identificacion') ? '' : 'selected' }} class="bg-[#001E30] text-slate-400">
                        Seleccionar documento...
                    </option>
                    <option value="CC" {{ old('tipo_identificacion') === 'CC' ? 'selected' : '' }} class="bg-[#001E30] text-white">
                        Cédula de Ciudadanía (CC)
                    </option>
                    <option value="TI" {{ old('tipo_identificacion') === 'TI' ? 'selected' : '' }} class="bg-[#001E30] text-white">
                        Tarjeta de Identidad (TI)
                    </option>
                    <option value="CE" {{ old('tipo_identificacion') === 'CE' ? 'selected' : '' }} class="bg-[#001E30] text-white">
                        Cédula de Extranjería (CE)
                    </option>
                    <option value="PPT" {{ old('tipo_identificacion') === 'PPT' ? 'selected' : '' }} class="bg-[#001E30] text-white">
                        Permiso Protección Temporal (PPT)
                    </option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
            @error('tipo_identificacion')
                <p class="text-xs text-rose-400 flex items-center gap-1 font-medium pt-0.5">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <label for="identificacion" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">
                Número de Documento <span class="text-[#8AFD5D]">*</span>
            </label>
            <input
                type="text"
                id="identificacion"
                name="identificacion"
                value="{{ old('identificacion') }}"
                required
                placeholder="Ej. 1023456789"
                class="w-full px-3.5 py-2.5 bg-[#001E30]/80 border @error('identificacion') border-rose-500/80 ring-1 ring-rose-500/40 @else border-white/10 focus:border-[#8AFD5D] focus:ring-1 focus:ring-[#8AFD5D] @enderror rounded-xl text-sm text-white placeholder-slate-500 outline-none transition-all duration-200"
            >
            @error('identificacion')
                <p class="text-xs text-rose-400 flex items-center gap-1 font-medium pt-0.5">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <label for="rol" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">
                Rol en la Institución <span class="text-[#8AFD5D]">*</span>
            </label>
            <div class="relative">
                <select
                    id="rol"
                    name="rol"
                    required
                    class="w-full px-3.5 py-2.5 bg-[#001E30]/80 border @error('rol') border-rose-500/80 ring-1 ring-rose-500/40 @else border-white/10 focus:border-[#8AFD5D] focus:ring-1 focus:ring-[#8AFD5D] @enderror rounded-xl text-sm text-white outline-none appearance-none transition-all duration-200 cursor-pointer pr-10"
                >
                    <option value="" disabled {{ old('rol') ? '' : 'selected' }} class="bg-[#001E30] text-slate-400">
                        Seleccionar rol...
                    </option>
                    <option value="aprendiz" {{ old('rol') === 'aprendiz' ? 'selected' : '' }} class="bg-[#001E30] text-white">
                        Aprendiz
                    </option>
                    <option value="instructor" {{ old('rol') === 'instructor' ? 'selected' : '' }} class="bg-[#001E30] text-white">
                        Instructor
                    </option>
                    <option value="aspirante" {{ old('rol') === 'aspirante' ? 'selected' : '' }} class="bg-[#001E30] text-white">
                        Aspirante
                    </option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
            @error('rol')
                <p class="text-xs text-rose-400 flex items-center gap-1 font-medium pt-0.5">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <label for="email" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">
                Correo Electrónico <span class="text-[#8AFD5D]">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    placeholder="ejemplo@correo.com"
                    class="w-full pl-10 pr-3.5 py-2.5 bg-[#001E30]/80 border @error('email') border-rose-500/80 ring-1 ring-rose-500/40 @else border-white/10 focus:border-[#8AFD5D] focus:ring-1 focus:ring-[#8AFD5D] @enderror rounded-xl text-sm text-white placeholder-slate-500 outline-none transition-all duration-200"
                >
            </div>
            @error('email')
                <p class="text-xs text-rose-400 flex items-center gap-1 font-medium pt-0.5">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>
    </div>
</div>
