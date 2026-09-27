@php
    $tema = $tema ?? 'admin';

    $estilos = [
        'admin' => [
            'fondo' => 'from-[#EAF6F4] via-[#F4F9FB] to-[#F0F5FF]',
            'anillo' => 'from-[#39A900] via-[#228B22] to-[#0E6B54]',
            'eyebrow' => 'text-[#1B5E6A]',
            'boton' => 'bg-[#8AFD5D] text-[#001E30] shadow-[#8AFD5D]/20 hover:bg-[#7CE84F]',
            'estado' => 'bg-[#39A900]',
        ],
        'aprendiz' => [
            'fondo' => 'from-[#EAF5F4] via-[#F4FAF8] to-[#EEF3F8]',
            'anillo' => 'from-[#39A900] via-[#228B22] to-[#0E6B54]',
            'eyebrow' => 'text-[#1B5E6A]',
            'boton' => 'bg-[#8AFD5D] text-[#001E30] shadow-[#8AFD5D]/20 hover:bg-[#7CE84F]',
            'estado' => 'bg-[#39A900]',
        ],
        'aspirante' => [
            'fondo' => 'from-[#FFF5F4] via-[#FFF8F6] to-[#F3F3FF]',
            'anillo' => 'from-[#C46D63] via-[#C46D63] to-[#A85950]',
            'eyebrow' => 'text-[#B17A79]',
            'boton' => 'bg-[#FFB0A5] text-[#2E1A1E] shadow-[#FFB0A5]/20 hover:bg-[#FFA093]',
            'estado' => 'bg-[#C46D63]',
        ],
        'instructor' => [
            'fondo' => 'from-[#EEF3FF] via-[#F4F7FF] to-[#EEF8FF]',
            'anillo' => 'from-[#39A900] via-[#228B22] to-[#0E6B54]',
            'eyebrow' => 'text-[#6078B5]',
            'boton' => 'bg-[#8FB4FF] text-[#0A2334] shadow-[#8FB4FF]/20 hover:bg-[#7EA7F5]',
            'estado' => 'bg-[#39A900]',
        ],
    ][$tema] ?? [
        'fondo' => 'from-[#EAF6F4] via-[#F4F9FB] to-[#F0F5FF]',
        'anillo' => 'from-[#39A900] via-[#228B22] to-[#0E6B54]',
        'eyebrow' => 'text-[#1B5E6A]',
        'boton' => 'bg-[#8AFD5D] text-[#001E30] shadow-[#8AFD5D]/20 hover:bg-[#7CE84F]',
        'estado' => 'bg-[#39A900]',
    ];

    $nombre = trim(
        ($usuario->nombre_1 ?? '') . ' ' .
        ($usuario->nombre_2 ?? '') . ' ' .
        ($usuario->apellido_1 ?? '') . ' ' .
        ($usuario->apellido_2 ?? '')
    );

    $nombre = $nombre ?: 'Usuario';
    $inicial = strtoupper(substr($usuario->nombre_1 ?? $nombre, 0, 1));

    // RESOLUCIÓN DE RUTA DE LA FOTO
    $foto = null;
    if (!empty($usuario->foto_perfil)) {
        if (filter_var($usuario->foto_perfil, FILTER_VALIDATE_URL)) {
            $foto = $usuario->foto_perfil;
        } else {
            // Intenta obtener la URL desde Storage
            $foto = Storage::disk('public')->exists($usuario->foto_perfil)
                ? Storage::url($usuario->foto_perfil)
                : asset('storage/' . ltrim($usuario->foto_perfil, '/'));
        }
    }

    $badges = $badges ?? [];
    $editLabel = $editLabel ?? 'Editar Perfil';
    $editRoute = $editRoute ?? '#';
@endphp

<section
    class="overflow-hidden rounded-[30px] border border-[#D8E6EB] bg-gradient-to-r {{ $estilos['fondo'] }} shadow-[0_20px_45px_rgba(15,40,53,0.08)]"
>
    <div class="p-6 md:p-8">

        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

            {{-- USUARIO --}}
            <div class="flex min-w-0 items-center gap-5">

                {{-- AVATAR --}}
                <div class="relative h-20 w-20 shrink-0 sm:h-24 sm:w-24">

                    {{-- ANILLO GRADIENTE --}}
                    <div class="absolute inset-0 rounded-full bg-gradient-to-br {{ $estilos['anillo'] }} p-[3px] shadow-[0_10px_25px_rgba(15,40,53,0.15)]">

                        {{-- CONTENEDOR FOTO --}}
                        <div class="relative h-full w-full overflow-hidden rounded-full bg-white">

                            @if ($foto)
                                <img
                                    src="{{ $foto }}"
                                    alt="Foto de perfil de {{ $nombre }}"
                                    class="h-full w-full object-cover object-center"
                                    loading="eager"
                                    onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden'); this.nextElementSibling.classList.add('flex');"
                                >

                                {{-- FALLBACK SI FALLA LA CARGA DE LA IMAGEN --}}
                                <div class="hidden h-full w-full items-center justify-center rounded-full bg-gradient-to-br {{ $estilos['anillo'] }}">
                                    <span class="select-none text-2xl font-black uppercase text-white sm:text-3xl">
                                        {{ $inicial }}
                                    </span>
                                </div>
                            @else
                                {{-- MOSTRAR INICIAL SI NO HAY FOTO --}}
                                <div class="flex h-full w-full items-center justify-center rounded-full bg-gradient-to-br {{ $estilos['anillo'] }}">
                                    <span class="select-none text-2xl font-black uppercase text-white sm:text-3xl">
                                        {{ $inicial }}
                                    </span>
                                </div>
                            @endif

                        </div>

                    </div>

                    {{-- INDICADOR DE ESTADO --}}
                    <span class="absolute bottom-0 right-0 z-30 flex h-6 w-6 items-center justify-center rounded-full border-[3px] border-white {{ $estilos['estado'] }} shadow-md">
                        <span class="h-2 w-2 rounded-full bg-white"></span>
                    </span>

                </div>

                {{-- INFORMACIÓN --}}
                <div class="min-w-0">

                    @if (!empty($eyebrow))
                        <p class="text-xs font-bold uppercase tracking-[0.28em] {{ $estilos['eyebrow'] }}">
                            {{ $eyebrow }}
                        </p>
                    @endif

                    <h1 class="mt-1 truncate text-2xl font-black text-[#0A2334] md:text-3xl">
                        {{ $nombre }}
                    </h1>

                    @if (!empty($subtitle))
                        <p class="mt-1 text-sm text-[#5F7785]">
                            {{ $subtitle }}
                        </p>
                    @endif

                    @if (count($badges))
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($badges as $badge)
                                <span class="rounded-full bg-white px-3 py-1 text-[10px] font-bold uppercase tracking-[0.15em] text-[#0A2334] shadow-sm">
                                    {{ $badge }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                </div>

            </div>

            {{-- ACCIONES: editar perfil y cerrar sesión --}}
            <div class="flex shrink-0 flex-col gap-3 sm:flex-row sm:items-center">

                <a
                    href="{{ $editRoute }}"
                    class="inline-flex shrink-0 items-center justify-center rounded-xl px-6 py-3 text-sm font-extrabold shadow-lg transition duration-200 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $estilos['boton'] }}"
                >
                    {{ $editLabel }}
                </a>

                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="inline-flex w-full shrink-0 items-center justify-center gap-2 rounded-xl border border-[#D8E6EB] bg-white px-5 py-3 text-sm font-extrabold text-[#5F7785] shadow-lg transition duration-200 hover:-translate-y-0.5 hover:border-[#C46D63] hover:text-[#C46D63] focus:outline-none focus:ring-2 focus:ring-[#C46D63]/40 focus:ring-offset-2 sm:w-auto"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        Cerrar sesión
                    </button>
                </form>

            </div>

        </div>

    </div>
</section>