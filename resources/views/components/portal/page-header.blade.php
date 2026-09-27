@props([
    'eyebrow',
    'title',
    'description',
])

<section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#EAF5F4] via-[#F1F8F7] to-[#E9F0F7] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.08)] md:p-8">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>

    <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">{{ $eyebrow }}</p>
            <h1 class="mt-3 text-3xl font-black leading-tight text-[#0A2334] md:text-4xl">{{ $title }}</h1>
            <p class="mt-3 max-w-3xl text-sm leading-relaxed text-[#3b5d6e] md:text-base">{{ $description }}</p>
        </div>

        @isset($actions)
            <div class="flex shrink-0 flex-col gap-3 sm:flex-row lg:flex-col xl:flex-row">
                {{ $actions }}
            </div>
        @endisset
    </div>
</section>
