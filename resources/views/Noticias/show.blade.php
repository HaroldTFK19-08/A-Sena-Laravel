@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', $noticia->titulo)

@section('contenido')
    <div class="space-y-8">
        <section class="rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.08)] md:p-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between"><div><span class="rounded-full bg-white/80 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-[#0E6B54]">{{ $noticia->estado }}</span><h1 class="mt-4 max-w-4xl text-3xl font-black leading-tight text-[#0A2334] md:text-4xl">{{ $noticia->titulo }}</h1><p class="mt-3 text-sm text-[#5F7785]">{{ $noticia->created_at?->translatedFormat('d \d\e F \d\e Y') }}</p></div><a href="{{ route('noticias.index') }}" class="inline-flex shrink-0 items-center justify-center rounded-xl border border-[#C7DCE2] bg-white/70 px-5 py-3 text-sm font-semibold text-[#0A2334]">Volver</a></div>
        </section>
        <article class="overflow-hidden rounded-[30px] border border-[#D8E6EB] bg-white shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
            @if ($noticia->imagen)<img src="{{ asset('storage/' . $noticia->imagen) }}" alt="{{ $noticia->titulo }}" class="max-h-[420px] w-full object-cover">@endif
            <div class="space-y-6 p-6 md:p-8"><div><p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Descripción</p><p class="mt-3 text-base leading-8 text-[#385568]">{{ $noticia->descripcion }}</p></div><div class="grid gap-4 border-t border-[#E3ECEF] pt-6 sm:grid-cols-2"><div><p class="text-xs font-bold uppercase tracking-wider text-[#78909C]">Centro de formación</p><p class="mt-2 font-bold text-[#0A2334]">{{ $noticia->trainingcenter?->nombre ?? 'Sin centro asignado' }}</p></div><div><p class="text-xs font-bold uppercase tracking-wider text-[#78909C]">Última actualización</p><p class="mt-2 font-bold text-[#0A2334]">{{ $noticia->updated_at?->format('d/m/Y H:i') }}</p></div></div><div class="flex flex-col gap-3 border-t border-[#E3ECEF] pt-6 sm:flex-row"><a href="{{ route('noticias.edit', $noticia) }}" class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30]">Editar noticia</a><form action="{{ route('noticias.destroy', $noticia) }}" method="POST" onsubmit="return confirm('¿Eliminar esta noticia?');">@csrf @method('DELETE')<button type="submit" class="inline-flex items-center justify-center rounded-xl border border-rose-200 bg-white px-5 py-3 text-sm font-semibold text-rose-500">Eliminar noticia</button></form></div></div>
        </article>
    </div>
@endsection
