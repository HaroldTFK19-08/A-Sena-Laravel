@props([
    'title',
    'description',
    'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
])

<div class="rounded-2xl border border-dashed border-[#C9DCE3] bg-white p-8 text-center shadow-sm md:p-10">
    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF6F4] text-[#0E6B54]">
        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $icon }}" />
        </svg>
    </div>
    <h3 class="mt-4 font-extrabold text-[#0A2334]">{{ $title }}</h3>
    <p class="mx-auto mt-2 max-w-xl text-sm leading-relaxed text-[#5F7785]">{{ $description }}</p>
    @isset($action)
        <div class="mt-5 flex justify-center">{{ $action }}</div>
    @endisset
</div>
