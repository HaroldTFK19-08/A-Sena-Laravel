{{-- SECCIÓN: SEGURIDAD Y ACCESO --}}
<div class="space-y-6 mx-5 my-5">

    <div class="flex items-center gap-3 pb-3 border-b border-white/10">
        <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-[#8AFD5D]/10 text-[#8AFD5D] ring-1 ring-[#8AFD5D]/20 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <div>
            <h3 class="text-sm font-bold uppercase tracking-[0.18em] text-white">
                Seguridad y Acceso
            </h3>
            <p class="text-[10px] text-slate-400 mt-0.5">
                Define tu contraseña de acceso
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div class="space-y-1.5">
            <label for="password" class="text-xs font-semibold text-slate-300 uppercase tracking-wider block">
                Contraseña <span class="text-[#8AFD5D]">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Máximo 8 caracteres"
                    maxlength="8"
                    class="w-full pl-10 pr-10 py-2.5 bg-[#001E30]/80 border @error('password') border-rose-500/80 ring-1 ring-rose-500/40 @else border-white/10 focus:border-[#8AFD5D] focus:ring-1 focus:ring-[#8AFD5D] @enderror rounded-xl text-sm text-white placeholder-slate-500 outline-none transition-all duration-200"
                >
                <button
                    type="button"
                    onclick="toggleFieldVisibility('password', this)"
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-white cursor-pointer transition-colors focus:outline-none"
                    aria-label="Mostrar u ocultar contraseña"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-xs text-rose-400 flex items-center gap-1 font-medium pt-0.5">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <label for="password_confirmation" class="text-xs font-semibold text-slate-300 uppercase tracking-wider block">
                Confirmar Contraseña <span class="text-[#8AFD5D]">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Repite la contraseña"
                    maxlength="8"
                    class="w-full pl-10 pr-10 py-2.5 bg-[#001E30]/80 border @error('password_confirmation') border-rose-500/80 ring-1 ring-rose-500/40 @else border-white/10 focus:border-[#8AFD5D] focus:ring-1 focus:ring-[#8AFD5D] @enderror rounded-xl text-sm text-white placeholder-slate-500 outline-none transition-all duration-200"
                >
                <button
                    type="button"
                    onclick="toggleFieldVisibility('password_confirmation', this)"
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-white cursor-pointer transition-colors focus:outline-none"
                    aria-label="Mostrar u ocultar confirmación de contraseña"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

