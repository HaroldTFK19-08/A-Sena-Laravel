@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Editar noticia')

@section('contenido')
    <div class="space-y-8">
        <section class="rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.08)] md:p-8">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Gestión de contenido</p>
            <div class="mt-3 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between"><div><h1 class="text-3xl font-black text-[#0A2334] md:text-4xl">Editar noticia</h1><p class="mt-3 text-sm text-[#3B5D6E] md:text-base">Actualiza la información de <span class="font-bold text-[#0A2334]">{{ $noticia->titulo }}</span>.</p></div><a href="{{ route('noticias.index') }}" class="inline-flex items-center justify-center rounded-xl border border-[#C7DCE2] bg-white/70 px-5 py-3 text-sm font-semibold text-[#0A2334]">Volver al listado</a></div>
        </section>
        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                <p class="font-bold">No se pudo actualizar la noticia.</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)] md:p-8">@include('Noticias.partials.form')</section>
    </div>
@endsection
