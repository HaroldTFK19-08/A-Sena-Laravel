<section class="relative py-12 sm:py-14 px-4 sm:px-6 overflow-hidden bg-[radial-gradient(circle_at_top,_rgba(138,253,93,0.12),_transparent_35%),linear-gradient(180deg,#001E30_0%,#081B28_100%)] flex-1 flex items-center justify-center min-h-[calc(100vh-10rem)]">
    <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:42px_42px] opacity-30"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[760px] h-[500px] bg-[#8AFD5D]/8 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-5xl mx-auto relative z-10">
        <div class="text-center mb-8">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-semibold text-[#8AFD5D] mb-4 shadow-sm backdrop-blur-sm">
                <span class="w-2 h-2 rounded-full bg-[#8AFD5D] animate-pulse"></span>
                Portal de Inscripción
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight uppercase mb-2">
                Crear <span class="text-[#8AFD5D]">Cuenta</span>
            </h1>
            <div class="w-16 h-1 bg-[#8AFD5D] mx-auto rounded-full mb-4"></div>
            <p class="text-slate-300 text-sm max-w-xl mx-auto leading-relaxed">
                Completa tus datos para registrarte en el sistema de gestión del SENA y acceder a tu portal institucional.
            </p>
        </div>

        <div class="relative bg-[#0A2A3F]/70 border border-white/10 rounded-[28px] p-5 sm:p-7 lg:p-10 shadow-[0_30px_80px_rgba(2,20,35,0.55)] backdrop-blur-md hover:border-[#8AFD5D]/40 transition-all duration-300">
            @if (session('error'))
                <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs flex items-center gap-2.5">
                    <svg class="w-4 h-4 shrink-0 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('auth.register.submit') }}" method="POST" class="space-y-8" novalidate enctype="multipart/form-data">
                @csrf

                <div class="space-y-8">
                    @include('Includes.Auth.RegisterPersonal')

                    <div class="h-px bg-white/[0.06]"></div>

                    @include('Includes.Auth.RegisterIdentificacion')

                    <div class="h-px bg-white/[0.06]"></div>

                    @include('Includes.Auth.RegisterSeguridad')
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full py-3.5 px-4 bg-[#8AFD5D] hover:bg-[#72db4c] text-[#001E30] font-black text-sm rounded-xl shadow-[0_12px_30px_rgba(138,253,93,0.25)] hover:shadow-[0_16px_35px_rgba(138,253,93,0.35)] transition-all duration-200 uppercase tracking-wider flex items-center justify-center gap-2 cursor-pointer group"
                    >
                        <span>Crear Cuenta</span>
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-white/10 text-center">
                <p class="text-xs text-slate-400">
                    ¿Ya tienes una cuenta registrada?
                    <a href="{{ route('auth.login') }}" class="text-[#8AFD5D] font-bold hover:underline transition-colors ml-1">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>

<script>
    function toggleFieldVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input) return;

        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';

        btn.innerHTML = isPassword
            ? `<svg class="w-4 h-4 text-[#8AFD5D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>`
            : `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`;
    }
</script>