<footer class="relative w-full bg-[#001E30] text-slate-300 border-t border-white/10 select-none overflow-hidden">
    {{-- Brillos decorativos --}}
    <div class="absolute -top-32 -left-20 w-80 h-80 bg-[#39A900]/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 right-0 w-96 h-96 bg-[#8AFD5D]/5 rounded-full blur-3xl pointer-events-none"></div>

    {{-- Contenido principal --}}
    <div class="max-w-7xl mx-auto px-6 py-12 relative">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10">
            
            {{-- Columna 1: Marca e Identidad --}}
            <div class="flex flex-col">
                <a href="{{ route('auth.inicio') }}" class="inline-flex items-center gap-3 group w-fit">
                    <div class="h-12 w-12 rounded-xl bg-white/10 border border-white/10 flex items-center justify-center shrink-0 group-hover:bg-[#39A900]/20 group-hover:border-[#39A900]/30 group-hover:scale-105 transition-all duration-300">
                        <img src="{{ asset('logoSena.svg') }}" alt="Logo SENA" class="h-9 w-9 object-contain">
                    </div>
                    <div class="flex flex-col justify-center">
                        <span class="text-xl font-extrabold text-white tracking-wider uppercase leading-none">
                            ADMIN <span class="text-[#8AFD5D]">SENA</span>
                        </span>
                        <span class="text-[10px] text-slate-400 font-medium tracking-[0.2em] uppercase mt-1">
                            Portal Institucional
                        </span>
                    </div>
                </a>

                <p class="text-sm text-slate-400 leading-relaxed mt-4">
                    Plataforma institucional para la gestión integral de centros, ambientes, áreas, instructores y aprendices del SENA.
                </p>

                {{-- Línea decorativa --}}
                <div class="flex items-center gap-1.5 mt-6">
                    <span class="w-8 h-1 rounded-full bg-[#39A900]"></span>
                    <span class="w-2.5 h-1 rounded-full bg-[#8AFD5D]"></span>
                    <span class="w-1.5 h-1 rounded-full bg-white/20"></span>
                </div>
            </div>

            {{-- Columna 2: Navegación --}}
            <div class="flex flex-col">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-1 h-4 bg-[#39A900] rounded-full"></span>
                    Navegación
                </h3>
                <ul class="space-y-2.5 text-sm">
                    <li>
                        <a href="{{ route('auth.inicio') }}" class="group inline-flex items-center gap-2 text-slate-400 hover:text-white transition-colors duration-200">
                            <span class="text-[#39A900] group-hover:text-[#8AFD5D] group-hover:translate-x-0.5 transition-transform duration-200">→</span>
                            Noticias
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('auth.inicio') }}" class="group inline-flex items-center gap-2 text-slate-400 hover:text-white transition-colors duration-200">
                            <span class="text-[#39A900] group-hover:text-[#8AFD5D] group-hover:translate-x-0.5 transition-transform duration-200">→</span>
                            Ofertas de formación
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Columna 3: Atención al ciudadano --}}
            <div class="flex flex-col">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-1 h-4 bg-[#39A900] rounded-full"></span>
                    Atención al Ciudadano
                </h3>
                <ul class="space-y-3.5 text-sm">
                    {{-- Dirección --}}
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-[#8AFD5D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <span class="text-slate-400 text-xs leading-relaxed">
                            <strong class="text-slate-300 font-semibold block">Dirección General:</strong>
                            Calle 57 No. 8 - 69, Bogotá D.C.
                        </span>
                    </li>

                    {{-- Teléfono --}}
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-[#8AFD5D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <span class="text-slate-400 text-xs">01 8000 910270</span>
                    </li>

                    {{-- Correo --}}
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-[#8AFD5D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-slate-400 text-xs truncate">soporte@sena.edu.co</span>
                    </li>
                </ul>
            </div>

            {{-- Columna 4: Estado del Sistema --}}
            <div class="flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-1 h-4 bg-[#39A900] rounded-full"></span>
                        Estado del Sistema
                    </h3>
                    
                    <div class="rounded-xl bg-white/5 border border-white/10 p-3.5">
                        <div class="flex items-center gap-3">
                            <div class="relative flex items-center justify-center w-3 h-3 shrink-0">
                                <span class="absolute inline-flex w-full h-full rounded-full bg-[#8AFD5D] animate-ping opacity-75"></span>
                                <span class="relative inline-flex w-2.5 h-2.5 rounded-full bg-[#8AFD5D]"></span>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-white">Sistema Operativo</p>
                                <p class="text-[11px] text-slate-400">Todos los servicios disponibles</p>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-[11px] text-slate-500 leading-relaxed mt-4">
                    Plataforma exclusiva para la gestión administrativa del SENA.
                </p>
            </div>

        </div>
    </div>

    {{-- Footer inferior --}}
    <div class="bg-[#001923]/80 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <p class="text-center sm:text-left">
                © {{ date('Y') }} <span class="text-slate-300 font-semibold">SENA</span>. Todos los derechos reservados.
            </p>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-[#8AFD5D] transition-colors duration-200">Políticas de Privacidad</a>
                <span class="text-slate-700">•</span>
                <a href="#" class="hover:text-[#8AFD5D] transition-colors duration-200">Términos de Uso</a>
            </div>
        </div>
    </div>
</footer>