<header class="sticky top-0 z-40 border-b border-[#D8E6EB]/80 bg-[#F8FBFC]/90 backdrop-blur-xl shadow-[0_8px_30px_rgba(15,40,53,0.06)]">
    <div class="flex items-center justify-between h-[76px] px-5 sm:px-6 lg:px-8">
        {{-- Logo móvil --}}
        <div class="flex items-center lg:hidden">
            <a href="{{ route('auth.inicio') }}" class="flex items-center gap-3 group">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-[#D8E6EB] shadow-sm group-hover:border-[#39A900] transition-all duration-200">
                    <img
                        src="{{ asset('logoSena.svg') }}"
                        alt="Logo SENA"
                        class="w-7 h-7 object-contain"
                    >
                </div>

                <div class="leading-tight">
                    <p class="text-[11px] font-bold tracking-[0.18em] text-[#607D8B]">
                        PLATAFORMA
                    </p>

                    <p class="text-sm font-black tracking-wide text-[#0A2334]">
                        ADMIN <span class="text-[#0E6B54]">SENA</span>
                    </p>
                </div>
            </a>
        </div>

        {{-- Espacio / título desktop --}}
        <div class="hidden lg:block">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#78909C]">
                    Panel administrativo
                </p>

                <h1 class="text-lg font-black tracking-tight text-[#0A2334]">
                    Gestión institucional
                </h1>
            </div>
        </div>

        {{-- Acciones --}}
        <div class="flex items-center gap-3 ml-auto">

            {{-- Notificaciones --}}
            <button
                type="button"
                aria-label="Notificaciones"
                class="relative flex items-center justify-center w-11 h-11 rounded-xl
                        bg-white border border-[#D8E6EB]
                        text-[#0E6B54]
                        hover:bg-[#F1FAEE]
                        hover:border-[#BFE6B1]
                        hover:shadow-sm
                        transition-all duration-200"
            >
                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0"
                    />
                </svg>

                {{-- Indicador --}}
                <span class="absolute top-2.5 right-2.5 w-2 h-2 rounded-full bg-[#39A900] ring-2 ring-white"></span>
            </button>
            {{-- Separador --}}
            <div class="hidden sm:block h-8 w-px bg-[#D8E6EB]"></div>
            {{-- Perfil --}}
            <a
                href="{{ route('admin.perfil') }}"
                class="flex items-center gap-3 pl-1 pr-2.5 py-1.5 rounded-xl hover:bg-white hover:shadow-sm transition-all duration-200"
            >
                {{-- Avatar con condicional para foto de perfil --}}
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#0E6B54] text-white shadow-sm overflow-hidden shrink-0">
                    @if(auth()->user()->foto_perfil)
                        <img
                            src="{{ asset('storage/' . auth()->user()->foto_perfil) }}"
                            alt="{{ auth()->user()->nombre_1 }}" 
                            class="w-full h-full object-cover"
                        >
                    @else
                        <span class="text-sm font-black">
                            {{ strtoupper(substr(auth()->user()->nombre_1 ?? 'A', 0, 1)) }}
                        </span>
                    @endif
                </div>

                <div class="hidden md:block text-left leading-tight">
                    <p class="text-sm font-bold text-[#0A2334]">
                        {{ auth()->user()->nombre_1 ?? 'Administrador' }}
                    </p>
                    <p class="text-[11px] font-medium text-[#78909C]">
                        Administrador
                    </p>
                </div>

                <svg
                    class="hidden md:block w-4 h-4 text-[#78909C]"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m6 9 6 6 6-6"
                    />
                </svg>
            </a>
        </div>
    </div>
</header>

