@extends('Layouts.Usuarios.AppAdmin')
@section('titulo', 'Detalle de asignación')
@section('contenido')
    <div class="space-y-8">
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#EAF5F4] via-[#F1F8F7] to-[#E9F0F7] p-6 md:p-8 shadow-[0_20px_45px_rgba(15,40,53,0.08)]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>
            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Detalle Académico</p>
                    <h1 class="mt-3 text-3xl md:text-4xl font-black text-[#0A2334] leading-tight">
                        Asignación #{{ $assignment->id }}
                    </h1>
                    <p class="mt-3 max-w-2xl text-sm md:text-base text-[#3b5d6e] leading-relaxed">
                        Información detallada de la entrega del equipo al aprendiz.
                    </p>
                </div>
                <div class="flex gap-3">
                    @if(auth()->user()?->rol === 'Instructor')
                        <a href="{{ route('instructor.asignaciones.edit', $assignment) }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-[#0E6B54] text-white font-bold transition-all hover:bg-[#0a5a46] shadow-lg hover:shadow-[#0e6b54]/30">
                            Editar
                        </a>
                    @endif
                    <a href="{{ auth()->user()?->rol === 'Admin' ? route('admin.asignaciones.index') : route('instructor.asignaciones.index') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-white text-[#0A2334] font-bold transition-all border border-[#D8E6EB] hover:bg-[#F1F8F7] shadow-sm">
                        Volver
                    </a>
                </div>
            </div>
        </section>

        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-8 shadow-[0_12px_26px_rgba(15,40,53,0.06)] space-y-6">
            <div class="grid gap-6 md:grid-cols-2">
                <div class="rounded-2xl border border-[#D8E6EB] bg-white p-5">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#5F7785]">Aprendiz</p>
                    <h3 class="mt-3 text-xl font-black text-[#0A2334]">{{ $assignment->apprentice?->user?->nombre_completo ?? 'No asignado' }}</h3>
                    <p class="mt-2 text-sm text-[#456073]">Ficha: {{ $assignment->apprentice?->coursegroup?->codigo ?? 'Sin ficha' }}</p>
                </div>
                <div class="rounded-2xl border border-[#D8E6EB] bg-white p-5">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#5F7785]">Equipo</p>
                    <h3 class="mt-3 text-xl font-black text-[#0A2334]">{{ $assignment->equipment?->name ?? 'Sin equipo' }}</h3>
                    <p class="mt-2 text-sm text-[#456073]">Ambiente: {{ $assignment->equipment?->environment?->nombre ?? 'Sin ambiente' }}</p>
                </div>
                <div class="rounded-2xl border border-[#D8E6EB] bg-white p-5">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#5F7785]">Fecha de asignación</p>
                    <h3 class="mt-3 text-xl font-black text-[#0A2334]">{{ $assignment->fecha_asignacion?->format('d/m/Y') }}</h3>
                </div>
                <div class="rounded-2xl border border-[#D8E6EB] bg-white p-5">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#5F7785]">Fecha de devolución</p>
                    <h3 class="mt-3 text-xl font-black text-[#0A2334]">{{ $assignment->fecha_devolucion?->format('d/m/Y') ?? 'Sin devolución' }}</h3>
                </div>
            </div>

            <div class="rounded-2xl border border-[#CBE4D5] bg-[#EAFBF0] p-5 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#0E6B54]">Estado actual</p>
                    <p class="mt-1 text-lg font-extrabold text-[#0A2334]">{{ $assignment->Estado }}</p>
                </div>
                <x-portal.status-badge :status="$assignment->Estado" />
            </div>
        </section>
    </div>
@endsection
