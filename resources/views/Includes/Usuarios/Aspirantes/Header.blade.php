<header class="sticky top-0 z-40 border-b border-[#F6D3D0] bg-[#FFF6F5]/95 backdrop-blur-xl shadow-[0_2px_12px_rgba(48,28,37,0.06)]">
    <div class="flex items-center justify-between h-20 px-5 sm:px-6 lg:px-8">
        <div class="flex items-center lg:hidden">
            <a href="{{ route('auth.inicio') }}" class="flex items-center gap-3 group">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-[#F6D3D0] shadow-sm group-hover:border-[#FFB0A5] transition-all duration-200">
                    <img src="{{ asset('logoSena.svg') }}" alt="Logo SENA" class="w-7 h-7 object-contain">
                </div>

                <div class="leading-tight">
                    <p class="text-[11px] font-bold tracking-[0.18em] text-[#B17A79]">
                        PLATAFORMA
                    </p>

                    <p class="text-sm font-black tracking-wide text-[#0A2334]">
                        ASPIRANTE <span class="text-[#C46D63]">SENA</span>
                    </p>
                </div>
            </a>
        </div>

        <div class="hidden lg:block">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#B17A79]">
                    Panel de admisión
                </p>

                <h1 class="text-lg font-black text-[#0A2334]">
                    Proceso de inscripción
                </h1>
            </div>
        </div>

        <div class="flex items-center gap-3 ml-auto">
            <button type="button" aria-label="Notificaciones" class="relative flex items-center justify-center w-11 h-11 rounded-xl bg-white border border-[#F6D3D0] text-[#C46D63] hover:bg-[#FFF0EE] hover:border-[#FFC3BA] hover:shadow-sm transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0"/>
                </svg>
                <span class="absolute top-2.5 right-2.5 w-2 h-2 rounded-full bg-[#C46D63] ring-2 ring-white"></span>
            </button>

            <div class="hidden sm:block h-8 w-px bg-[#F6D3D0]"></div>

            <a href="{{ route('aspirante.perfil') }}" class="flex items-center gap-3 pl-1 pr-2 py-1.5 rounded-xl hover:bg-white hover:shadow-sm transition-all duration-200">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#C46D63] text-white shadow-sm">
                    <span class="text-sm font-black">
                        {{ strtoupper(substr(auth()->user()->nombre_1 ?? 'A', 0, 1)) }}
                    </span>
                </div>

                <div class="hidden md:block text-left leading-tight">
                    <p class="text-sm font-bold text-[#0A2334]">
                        {{ auth()->user()->nombre_1 ?? 'Aspirante' }}
                    </p>

                    <p class="text-[11px] font-medium text-[#B17A79]">
                        Aspirante
                    </p>
                </div>

                <svg class="hidden md:block w-4 h-4 text-[#B17A79]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
                </svg>
            </a>
        </div>
    </div>
</header>
