@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Noticias')

@section('contenido')
    <div class="space-y-8">
        {{-- ===== Encabezado ===== --}}
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.08)] md:p-8">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>
            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Gestión de contenido</p>
                    <h1 class="mt-3 text-3xl font-black leading-tight text-[#0A2334] md:text-4xl">Noticias</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-[#3B5D6E] md:text-base">Crea, actualiza y organiza las noticias institucionales para los usuarios de la plataforma.</p>
                </div>
                <a href="{{ route('noticias.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30] shadow-lg shadow-[#8AFD5D]/20 transition-transform hover:-translate-y-0.5">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Nueva noticia
                </a>
            </div>
        </section>

        @if (session('success'))
            <div class="flex items-center gap-3 rounded-2xl border border-[#BFE6B1] bg-[#EAFBF0] p-4 text-sm font-semibold text-[#0E6B54]">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- ===== Métricas ===== --}}
        <section class="grid gap-5 sm:grid-cols-3">
            @php
                $totalNoticias = $noticias->count();
                $publicadas = $noticias->where('estado', 'Publicado')->count();
                $pendientes = $noticias->where('estado', 'Pendiente')->count();
                $metrics = [
                    ['label' => 'Total', 'value' => $totalNoticias, 'badge' => 'bg-[#D8F7CB] text-[#0E6B54]', 'icon' => 'M3 7.5h18M3 12h18M3 16.5h12'],
                    ['label' => 'Publicadas', 'value' => $publicadas, 'badge' => 'bg-[#DDF0FF] text-[#1B5E6A]', 'icon' => 'M4.5 12.75l6 6 9-13.5'],
                    ['label' => 'Pendientes', 'value' => $pendientes, 'badge' => 'bg-[#FFF1D6] text-[#9A6500]', 'icon' => 'M12 9v3.75m0 3.75h.008M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z'],
                ];
            @endphp
            @foreach ($metrics as $metric)
                <div class="flex items-center justify-between rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                    <div>
                        <p class="text-sm text-[#4B6473]">{{ $metric['label'] }}</p>
                        <p class="mt-3 text-3xl font-black text-[#0A2334]">{{ $metric['value'] }}</p>
                    </div>
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl {{ $metric['badge'] }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $metric['icon'] }}"/></svg>
                    </span>
                </div>
            @endforeach
        </section>

        {{-- ===== Listado ===== --}}
        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
            <div class="mb-6 flex flex-col gap-4">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Listado</p>
                        <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Todas las noticias</h2>
                    </div>
                    <p id="resultado-conteo" class="text-sm text-[#78909C]">{{ $totalNoticias }} {{ $totalNoticias === 1 ? 'noticia registrada' : 'noticias registradas' }}</p>
                </div>
                @if ($totalNoticias > 0)
                    {{-- Buscador y filtro (100% del lado del cliente, no requiere cambios en el controlador) --}}
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <div class="relative flex-1">
                            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8FA3AD]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M18 11a7 7 0 1 1-14 0 7 7 0 0 1 14 0z"/></svg>
                            <input
                                type="search"
                                id="buscador-noticias"
                                placeholder="Buscar por título..."
                                class="w-full rounded-xl border border-[#D8E6EB] bg-white py-2.5 pl-10 pr-4 text-sm text-[#0A2334] placeholder:text-[#9BAEB7] focus:border-[#8AFD5D] focus:outline-none focus:ring-2 focus:ring-[#8AFD5D]/40"
                            >
                        </div>
                        <select id="filtro-estado" class="rounded-xl border border-[#D8E6EB] bg-white px-4 py-2.5 text-sm font-semibold text-[#3B5D6E] focus:border-[#8AFD5D] focus:outline-none focus:ring-2 focus:ring-[#8AFD5D]/40">
                            <option value="">Todos los estados</option>
                            @foreach ($noticias->pluck('estado')->unique()->filter() as $estadoOption)
                                <option value="{{ $estadoOption }}">{{ $estadoOption }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

            @if ($noticias->isEmpty())
                <div class="rounded-2xl border border-dashed border-[#D8E6EB] bg-white p-10 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#EAF6F4] text-[#0E6B54]">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-6h4.5m-4.5 3h4.5m-6 3h.008v.008H8.25v-.008ZM6 20.25h12a2.25 2.25 0 0 0 2.25-2.25V6.31a2.25 2.25 0 0 0-.659-1.591L15.94 1.06A2.25 2.25 0 0 0 14.34.401H6a2.25 2.25 0 0 0-2.25 2.25v15.348A2.25 2.25 0 0 0 6 20.25Z"/></svg>
                    </div>
                    <p class="mt-4 text-sm font-semibold text-[#5F7785]">Aún no hay noticias registradas.</p>
                    <a href="{{ route('noticias.create') }}" class="mt-4 inline-flex rounded-xl bg-[#8AFD5D] px-5 py-2.5 text-sm font-extrabold text-[#001E30]">Crear la primera noticia</a>
                </div>
            @else
                <div id="grid-noticias" class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($noticias as $noticia)
                        @php
                            $estadoClases = match ($noticia->estado) {
                                'Publicado' => 'bg-[#D8F7CB] text-[#0E6B54]',
                                'Pendiente' => 'bg-[#FFF1D6] text-[#9A6500]',
                                default => 'bg-[#E7ECEF] text-[#4B6473]',
                            };
                        @endphp
                        <article
                            data-titulo="{{ Str::lower($noticia->titulo) }}"
                            data-estado="{{ $noticia->estado }}"
                            class="tarjeta-noticia flex min-h-[300px] flex-col overflow-hidden rounded-2xl border border-[#D8E6EB] bg-white transition duration-200 hover:-translate-y-1 hover:border-[#B8D8C2] hover:shadow-[0_16px_32px_rgba(15,40,53,0.1)]"
                        >
                            @if ($noticia->imagen)
                                <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="{{ $noticia->titulo }}" loading="lazy" class="h-48 w-full shrink-0 object-cover">
                            @else
                                <div class="flex h-48 w-full shrink-0 items-center justify-center bg-[#EAF6F4] text-5xl font-black text-[#0E6B54]">{{ strtoupper(substr($noticia->titulo, 0, 1)) }}</div>
                            @endif
                            <div class="flex min-w-0 flex-1 flex-col p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <h3 class="line-clamp-2 text-lg font-extrabold leading-snug text-[#0A2334]">{{ $noticia->titulo }}</h3>
                                    <span class="shrink-0 rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider {{ $estadoClases }}">{{ $noticia->estado }}</span>
                                </div>
                                <div class="mt-auto flex items-center justify-between gap-2 border-t border-[#EAF1F3] pt-4">
                                    <a href="{{ route('noticias.show', $noticia) }}" title="Vista previa" aria-label="Vista previa de {{ $noticia->titulo }}" class="inline-flex items-center gap-2 rounded-lg bg-[#EAF6F4] px-3 py-2 text-xs font-bold text-[#0E6B54] transition hover:bg-[#D8F7CB]">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/></svg>
                                        Preview
                                    </a>
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('noticias.edit', $noticia) }}" title="Editar noticia" aria-label="Editar {{ $noticia->titulo }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#D8E6EB] bg-white text-[#1B5E6A] transition hover:border-[#BBD9E6] hover:bg-[#F0F7FB]">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931z"/></svg>
                                        </a>
                                        <form action="{{ route('noticias.destroy', $noticia) }}" method="POST" onsubmit="return confirm('¿Eliminar esta noticia?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" title="Eliminar noticia" aria-label="Eliminar {{ $noticia->titulo }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-rose-200 bg-white text-rose-500 transition hover:border-rose-300 hover:bg-rose-50">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 7h12m-9 0V5.5A1.5 1.5 0 0 1 10.5 4h3A1.5 1.5 0 0 1 15 5.5V7m-7 0 .7 12.1A2 2 0 0 0 10.7 21h2.6a2 2 0 0 0 2-1.9L16 7M10 11v6m4-6v6"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Estado vacío para cuando el filtro no arroja resultados --}}
                <div id="sin-resultados" class="hidden rounded-2xl border border-dashed border-[#D8E6EB] bg-white p-10 text-center">
                    <p class="text-sm font-semibold text-[#5F7785]">Ninguna noticia coincide con tu búsqueda.</p>
                    <button type="button" id="limpiar-filtros" class="mt-4 inline-flex rounded-xl border border-[#D8E6EB] bg-white px-5 py-2.5 text-sm font-extrabold text-[#1B5E6A] transition hover:bg-[#F0F7FB]">Limpiar filtros</button>
                </div>

                @if (method_exists($noticias, 'links'))
                    <div class="mt-8">{{ $noticias->links() }}</div>
                @endif
            @endif
        </section>
    </div>

    @if ($noticias->isNotEmpty())
        @push('scripts')
            <script>
                (function () {
                    const buscador = document.getElementById('buscador-noticias');
                    const filtroEstado = document.getElementById('filtro-estado');
                    const tarjetas = Array.from(document.querySelectorAll('.tarjeta-noticia'));
                    const contador = document.getElementById('resultado-conteo');
                    const sinResultados = document.getElementById('sin-resultados');
                    const limpiarBtn = document.getElementById('limpiar-filtros');
                    const grid = document.getElementById('grid-noticias');

                    function aplicarFiltros() {
                        const texto = (buscador?.value || '').trim().toLowerCase();
                        const estado = filtroEstado?.value || '';
                        let visibles = 0;

                        tarjetas.forEach((tarjeta) => {
                            const coincideTexto = !texto
                                || tarjeta.dataset.titulo.includes(texto);
                            const coincideEstado = !estado || tarjeta.dataset.estado === estado;
                            const visible = coincideTexto && coincideEstado;
                            tarjeta.classList.toggle('hidden', !visible);
                            if (visible) visibles++;
                        });

                        if (contador) {
                            contador.textContent = `${visibles} ${visibles === 1 ? 'noticia encontrada' : 'noticias encontradas'}`;
                        }
                        if (sinResultados) sinResultados.classList.toggle('hidden', visibles !== 0);
                        if (grid) grid.classList.toggle('hidden', visibles === 0);
                    }

                    buscador?.addEventListener('input', aplicarFiltros);
                    filtroEstado?.addEventListener('change', aplicarFiltros);
                    limpiarBtn?.addEventListener('click', () => {
                        if (buscador) buscador.value = '';
                        if (filtroEstado) filtroEstado.value = '';
                        aplicarFiltros();
                    });
                })();
            </script>
        @endpush
    @endif
@endsection