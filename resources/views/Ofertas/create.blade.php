@extends('Layouts.Usuarios.AppAdmin')
@section('titulo', 'Nueva oferta')
@section('contenido')<div class="space-y-8">
        <section
            class="rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 md:p-8">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Gestión académica</p>
            <h1 class="mt-3 text-3xl font-black text-[#0A2334] md:text-4xl">Nueva oferta</h1>
            <p class="mt-3 text-sm text-[#3B5D6E]">Configura las fechas y cupos de la convocatoria.</p>
        </section>
        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 md:p-8">@include('Ofertas.partials.form')
        </section>
</div>@endsection
