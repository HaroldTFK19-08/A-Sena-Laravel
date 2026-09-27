@props([
    'label',
    'value',
    'description' => null,
    'icon',
    'tone' => 'emerald',
])

@php
    $tones = [
        'emerald' => 'bg-[#D8F7CB] text-[#0E6B54]',
        'blue' => 'bg-[#E4EBFF] text-[#4B6BC8]',
        'amber' => 'bg-[#FFF0C7] text-[#A96700]',
        'rose' => 'bg-[#FFE5E1] text-[#B14E42]',
        'slate' => 'bg-[#E6EEF2] text-[#526A78]',
    ];
    $iconTone = $tones[$tone] ?? $tones['emerald'];
@endphp

<div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
    <div class="flex items-center justify-between gap-3">
        <p class="text-sm text-[#4b6473]">{{ $label }}</p>
        <span class="rounded-xl p-2 {{ $iconTone }}" aria-hidden="true">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $icon }}" />
            </svg>
        </span>
    </div>
    <p class="mt-5 text-3xl font-black text-[#0A2334]">{{ $value }}</p>
    @if ($description)
        <p class="mt-2 text-xs text-[#5F7785]">{{ $description }}</p>
    @endif
</div>
