@extends('Layouts.Usuarios.AppAdmin')
@section('titulo', 'Editar asignación')
@section('contenido')
    <div class="space-y-8">
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#EAF5F4] via-[#F1F8F7] to-[#E9F0F7] p-6 md:p-8 shadow-[0_20px_45px_rgba(15,40,53,0.08)]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>
            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Gestión Docente</p>
                    <h1 class="mt-3 text-3xl md:text-4xl font-black text-[#0A2334] leading-tight">
                        Editar Asignación
                    </h1>
                    <p class="mt-3 max-w-2xl text-sm md:text-base text-[#3b5d6e] leading-relaxed">
                        Actualiza la información de la asignación seleccionada.
                    </p>
                </div>
                <a href="{{ route('instructor.asignaciones.index') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-white text-[#0A2334] font-bold transition-all border border-[#D8E6EB] hover:bg-[#F1F8F7] shadow-sm">
                    Volver al listado
                </a>
            </div>
        </section>

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-8 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
            <div class="mb-6">
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Formulario</p>
                <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Datos de la asignación</h2>
            </div>
            @include('Asignaciones.partials.form', ['action' => route('instructor.asignaciones.update', $assignment), 'method' => 'PUT'])
        </section>
    </div>
@endsection
