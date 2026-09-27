<header class="w-full bg-[#001E30] border-b border-white/10 shadow-xl sticky top-0 z-50 select-none overflow-hidden">
    <!-- Brillo decorativo -->
    <div class="absolute -top-20 left-1/3 w-72 h-40 bg-[#39A900]/10 blur-3xl rounded-full pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between relative">
        <!-- Logo y nombre -->
        <a href="{{ route('auth.inicio') }}"
            class="flex items-center gap-3 group">
            <!-- Contenedor del logo -->
            <div class="h-11 w-11 rounded-xl
                        bg-white/10 border border-white/10
                        flex items-center justify-center
                        shadow-lg
                        group-hover:bg-[#39A900]/20
                        group-hover:border-[#39A900]/30
                        group-hover:scale-105
                        transition-all duration-300">

                <img
                    src="{{ asset('logoSena.svg') }}"
                    alt="Logo SENA"
                    class="h-9 w-9"
                >

            </div>

            <!-- Nombre -->
            <div class="flex flex-col">

                <span class="text-xl font-extrabold tracking-wider uppercase leading-none text-white">
                    ADMIN
                    <span class="text-[#8AFD5D]">SENA</span>
                </span>

                <span class="text-[10px] text-slate-400 font-medium
                             tracking-[0.2em] uppercase mt-1">
                    Portal Institucional
                </span>

            </div>

        </a>

        <!-- Navbar -->
        <div class="flex items-center gap-4">
            @include('Includes.Auth.Navbar')
        </div>

    </div>

    <!-- Línea verde inferior -->
    <div class="h-[2px] bg-gradient-to-r from-transparent via-[#39A900] to-transparent"></div>

</header>
