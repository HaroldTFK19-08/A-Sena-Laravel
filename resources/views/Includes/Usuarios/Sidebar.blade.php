@php
    $theme = $theme ?? [
        'surface' => '#08283B',
        'surface_end' => '#041A2A',
        'line' => 'white/[0.08]',
        'accent' => '#8AFD5D',
        'muted' => '#94A3B8',
        'text' => '#CBD5E1',
        'status_label' => 'Estado',
        'status_text' => 'Sistema operativo',
        'status_percent' => 100,
    ];

    $sections = $sections ?? [];
    $currentRoute = request()->route();
    $currentRouteName = $currentRoute?->getName();
@endphp

<aside
    class="hidden h-screen w-72 shrink-0 flex-col border-r shadow-2xl lg:flex"
    style="background: linear-gradient(180deg, {{ $theme['surface'] }} 0%, {{ $theme['surface_end'] }} 100%); border-color: color-mix(in srgb, {{ $theme['accent'] }} 14%, transparent);"
>
    <div class="flex h-20 shrink-0 items-center border-b px-5" style="border-color: {{ $theme['line'] }};">
        <a href="{{ route('auth.inicio') }}" class="group flex w-full items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-white/10 bg-white/5 transition-all duration-200 group-hover:bg-white/10" style="--tw-border-opacity: .45; border-color: color-mix(in srgb, {{ $theme['accent'] }} 45%, transparent);">
                <img src="{{ asset('logoSena.svg') }}" alt="Logo SENA" class="h-7 w-7 object-contain">
            </div>
            <div class="min-w-0">
                <p class="truncate text-base font-black uppercase leading-none tracking-wider text-white">
                    {{ $portalTitle }} <span style="color: {{ $theme['accent'] }};">SENA</span>
                </p>
                <p class="mt-1 truncate text-[9px] font-semibold uppercase tracking-[0.2em]" style="color: {{ $theme['muted'] }};">
                    {{ $portalSubtitle }}
                </p>
            </div>
        </a>
    </div>

    <nav class="min-h-0 flex-1 space-y-2 overflow-y-auto px-3 py-5 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" aria-label="Navegación principal">
        @foreach ($sections as $section)
            @php
                $sectionItems = $section['items'] ?? [];
                $sectionIsActive = collect($sectionItems)->contains(function ($item) use ($currentRouteName) {
                    $activePattern = $item['active'] ?? $item['route'] ?? null;
                    return !empty($activePattern) && $currentRouteName && request()->routeIs($activePattern);
                });
                $sectionId = 'sidebar-section-' . $loop->index;
            @endphp

            <details class="group/section" @if($sectionIsActive || ($section['open'] ?? false)) open @endif>
                <summary class="flex cursor-pointer list-none items-center justify-between rounded-lg px-3 py-2 text-[10px] font-bold uppercase tracking-[0.2em] transition hover:bg-white/[0.04]" style="color: {{ $theme['muted'] }};" aria-controls="{{ $sectionId }}">
                    <span>{{ $section['label'] }}</span>
                    <svg class="h-3.5 w-3.5 transition-transform group-open/section:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6 9 6 6 6-6" />
                    </svg>
                </summary>

                <div id="{{ $sectionId }}" class="mt-1 space-y-1">
                    @foreach ($sectionItems as $item)
                        @php
                            $activePattern = $item['active'] ?? $item['route'] ?? null;
                            $isActive = !empty($activePattern) && $currentRouteName && request()->routeIs($activePattern);
                            $href = !empty($item['route']) ? route($item['route']) : ($item['href'] ?? '#');
                        @endphp
                        <a
                            href="{{ $href }}"
                            @if($isActive) aria-current="page" @endif
                            class="group relative flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition-all duration-200 {{ $isActive ? 'shadow-sm' : 'hover:bg-white/[0.05] hover:text-white' }}"
                            style="{{ $isActive ? 'background: color-mix(in srgb, ' . $theme['accent'] . ' 12%, transparent); color: ' . $theme['accent'] . ';' : 'color: ' . $theme['text'] . ';' }}"
                        >
                            @if($isActive)
                                <span class="absolute left-0 h-6 w-1 rounded-r-full" style="background: {{ $theme['accent'] }};"></span>
                            @endif
                            <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $item['icon'] }}" />
                            </svg>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </details>
        @endforeach

        <div class="border-t pt-4" style="border-color: {{ $theme['line'] }};">
            <div class="rounded-2xl border bg-white/[0.04] p-3.5" style="border-color: color-mix(in srgb, {{ $theme['accent'] }} 16%, transparent);">
                <div class="flex items-center justify-between gap-2">
                    <div>
                        <p class="text-[9px] font-bold uppercase tracking-[0.18em]" style="color: {{ $theme['muted'] }};">{{ $theme['status_label'] }}</p>
                        <div class="mt-1.5 flex items-center gap-2">
                            <span class="relative flex h-2 w-2">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full opacity-60" style="background: {{ $theme['accent'] }};"></span>
                                <span class="relative inline-flex h-2 w-2 rounded-full" style="background: {{ $theme['accent'] }};"></span>
                            </span>
                            <span class="text-xs font-semibold text-slate-200">{{ $theme['status_text'] }}</span>
                        </div>
                    </div>
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg" style="background: color-mix(in srgb, {{ $theme['accent'] }} 12%, transparent); color: {{ $theme['accent'] }};">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m5 12 4 4L19 6" />
                        </svg>
                    </span>
                </div>
                <div class="mt-2.5 h-1 overflow-hidden rounded-full bg-white/10">
                    <div class="h-full rounded-full" style="width: {{ $theme['status_percent'] }}%; background: {{ $theme['accent'] }};"></div>
                </div>
            </div>
        </div>
    </nav>
</aside>

<nav class="fixed inset-x-0 bottom-0 z-50 border-t bg-white/95 px-3 py-2 shadow-[0_-8px_24px_rgba(15,40,53,0.12)] backdrop-blur-xl lg:hidden" aria-label="Navegación móvil">
    <div class="flex snap-x gap-1 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        @foreach ($sections as $section)
            @foreach ($section['items'] as $item)
                @php
                    $activePattern = $item['active'] ?? $item['route'] ?? null;
                    $isActive = !empty($activePattern) && $currentRouteName && request()->routeIs($activePattern);
                    $href = !empty($item['route']) ? route($item['route']) : ($item['href'] ?? '#');
                @endphp
                <a href="{{ $href }}" @if($isActive) aria-current="page" @endif class="flex min-w-[76px] snap-start flex-col items-center gap-1 rounded-xl px-2 py-2 text-center text-[10px] font-bold transition {{ $isActive ? 'bg-[#EAF6F4] text-[#0E6B54]' : 'text-[#5F7785] hover:bg-[#F1F8F7] hover:text-[#0A2334]' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $item['icon'] }}" />
                    </svg>
                    <span class="max-w-[72px] truncate">{{ $item['label'] }}</span>
                </a>
            @endforeach
        @endforeach
    </div>
</nav>
