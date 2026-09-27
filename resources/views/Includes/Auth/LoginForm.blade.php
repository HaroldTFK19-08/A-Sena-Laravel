<section class="relative flex min-h-[calc(100vh-10rem)] flex-1 items-center justify-center overflow-hidden bg-[radial-gradient(circle_at_top,_rgba(138,253,93,0.16),_transparent_30%),linear-gradient(180deg,#001E30_0%,#081B28_100%)] px-6 py-16">
    <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:42px_42px] opacity-25"></div>
    <div class="absolute left-1/2 top-1/2 h-[520px] w-[520px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-[#8AFD5D]/8 blur-3xl"></div>

    <div class="relative z-10 mx-auto w-full max-w-6xl">
        <div class="grid items-center gap-8 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="hidden items-center justify-center lg:flex">
                <div class="w-full max-w-xl rounded-[32px] border border-white/10 bg-[#0A2A3F]/55 p-8 shadow-[0_30px_80px_rgba(2,20,35,0.45)] backdrop-blur-sm">
                    <div class="inline-flex items-center gap-2 rounded-full border border-[#8AFD5D]/30 bg-[#8AFD5D]/10 px-3 py-1.5 text-[10px] font-bold uppercase tracking-[0.22em] text-[#8AFD5D]">
                        <span class="h-2 w-2 rounded-full bg-[#8AFD5D]"></span>
                        Portal institucional
                    </div>

                    <h1 class="mt-6 text-4xl font-black uppercase leading-none tracking-tight text-white">
                        Bienvenido
                    </h1>

                    <p class="mt-4 text-base leading-relaxed text-slate-300">
                        Accede a una experiencia segura y organizada para gestionar usuarios, programas, fichas,
                        instructores y procesos académicos del SENA de acuerdo a su rol dentro de la plataforma. 
                    </p>

                    <div class="mt-8 space-y-4">
                        <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 p-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#8AFD5D]/10 text-[#8AFD5D]">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white">Acceso rápido y seguro</p>
                                <p class="text-xs text-slate-400">Protección y flujo ordenado por roles</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 p-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#8AFD5D]/10 text-[#8AFD5D]">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white">Gestión centralizada</p>
                                <p class="text-xs text-slate-400">Centros, cursos, docentes y aprendices</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mx-auto w-full max-w-md">
                <div class="relative rounded-[28px] border border-white/10 bg-[#0A2A3F]/65 p-7 shadow-[0_30px_80px_rgba(2,20,35,0.48)] backdrop-blur-sm sm:p-8">
                    <div class="text-center">
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3.5 py-1.5 text-[10px] font-semibold uppercase tracking-[0.22em] text-[#8AFD5D]">
                            <span class="h-2 w-2 rounded-full bg-[#8AFD5D] animate-pulse"></span>
                            Acceso al sistema
                        </span>
                        <h2 class="mt-5 text-3xl font-black uppercase tracking-tight text-white">
                            Iniciar <span class="text-[#8AFD5D]">sesión</span>
                        </h2>
                        <div class="mx-auto mt-3 h-1 w-14 rounded-full bg-[#8AFD5D]"></div>
                    </div>

                    @if (session('status'))
                        <div class="mt-6 rounded-xl border border-[#8AFD5D]/30 bg-[#8AFD5D]/10 p-3.5 text-xs text-[#8AFD5D]">
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>{{ session('status') }}</span>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mt-6 rounded-xl border border-rose-500/30 bg-rose-500/10 p-3.5 text-xs text-rose-300">
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <span>{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('auth.login.submit') }}" method="POST" class="mt-6 space-y-5" novalidate>
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-xs font-semibold uppercase tracking-[0.18em] text-slate-300">
                                Correo electrónico
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                                </div>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    autofocus
                                    placeholder="ejemplo@correo.com"
                                    class="w-full rounded-xl border bg-[#001E30]/80 py-3 pl-11 pr-4 text-sm text-white placeholder-slate-500 outline-none transition-all duration-200 @error('email') border-rose-500/80 ring-1 ring-rose-500/40 @else border-white/10 focus:border-[#8AFD5D] focus:ring-1 focus:ring-[#8AFD5D] @enderror"
                                >
                            </div>
                            @error('email')
                                <p class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-rose-400">
                                    <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between">
                                <label for="password" class="block text-xs font-semibold uppercase tracking-[0.18em] text-slate-300">
                                    Contraseña
                                </label>
                            </div>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="••••••••"
                                    class="w-full rounded-xl border bg-[#001E30]/80 py-3 pl-11 pr-11 text-sm text-white placeholder-slate-500 outline-none transition-all duration-200 @error('password') border-rose-500/80 ring-1 ring-rose-500/40 @else border-white/10 focus:border-[#8AFD5D] focus:ring-1 focus:ring-[#8AFD5D] @enderror"
                                >
                                <button
                                    type="button"
                                    onclick="togglePasswordVisibility('password', this)"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 transition-colors hover:text-white"
                                    aria-label="Mostrar u ocultar contraseña"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-rose-400">
                                    <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between text-xs text-slate-300">
                            <label class="inline-flex cursor-pointer items-center gap-2 select-none hover:text-white">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    id="remember"
                                    class="h-4 w-4 rounded border-white/20 bg-[#001E30] text-[#8AFD5D] focus:ring-[#8AFD5D] focus:ring-offset-0"
                                >
                                <span>Recordar sesión</span>
                            </label>
                        </div>

                        <button
                            type="submit"
                            class="mt-2 flex w-full cursor-pointer items-center justify-center gap-2 rounded-xl bg-[#8AFD5D] px-4 py-3.5 text-sm font-black uppercase tracking-[0.16em] text-[#001E30] shadow-[0_16px_32px_rgba(138,253,93,0.25)] transition-all duration-200 hover:bg-[#72db4c]"
                        >
                            <span>Iniciar sesión</span>
                            <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </form>

                    <div class="mt-8 border-t border-white/10 pt-6 text-center">
                        <p class="text-xs text-slate-400">
                            ¿No tienes una cuenta?
                            <a href="{{ route('auth.register') }}" class="ml-1 font-bold text-[#8AFD5D] transition-colors hover:underline">
                                Regístrate aquí
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input) return;

        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';

        btn.innerHTML = isPassword
            ? `<svg class="h-5 w-5 text-[#8AFD5D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>`
            : `<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`;
    }
</script>

