@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Perfil Aprendiz')

@section('contenido')
    @php
        $aprendizData = $usuario->apprentice;
        $courseGroup = $aprendizData?->coursegroup;
    @endphp

    <div class="space-y-8">
        @include('Usuarios.partials.perfilHeader', [
            'tema' => 'aprendiz',
            'usuario' => $usuario,
            'eyebrow' => 'Perfil del aprendiz',
            'subtitle' => ($courseGroup?->codigo ?? 'Ficha no asignada') . ' · ' . ($aprendizData?->estado ?? 'Estado no registrado'),
            'editRoute' => route('aprendiz.edit'),
        ])

        <section class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-[28px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-xl font-extrabold text-[#0A2334]">Información personal</h2>
                    <span class="rounded-full bg-[#D8F7CB] px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-[#0E6B54]">Cuenta</span>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:shadow-sm">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Tipo de identificación</p>
                        <p class="mt-2 text-base font-bold text-[#0A2334]">{{ $usuario->tipo_identificacion ?? 'No registrado' }}</p>
                    </div>

                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:shadow-sm">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Identificación</p>
                        <p class="mt-2 text-base font-bold text-[#0A2334]">{{ $usuario->identificacion ?? 'No registrado' }}</p>
                    </div>

                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:shadow-sm">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Correo electrónico</p>
                        <p class="mt-2 break-all text-sm font-bold text-[#0A2334]">{{ $usuario->email ?? 'No registrado' }}</p>
                    </div>

                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:shadow-sm">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Rol</p>
                        <p class="mt-2 text-base font-bold text-[#0A2334]">{{ ucfirst($usuario->rol ?? 'Sin rol') }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-[28px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-xl font-extrabold text-[#0A2334]">Datos de formación</h2>
                    <span class="rounded-full bg-[#EAF6F4] px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-[#1B5E6A]">Ficha</span>
                </div>

                <div class="space-y-4">
                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:shadow-sm">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Ficha</p>
                        <p class="mt-2 text-base font-bold text-[#0A2334]">{{ $courseGroup?->codigo ?? 'Sin ficha asociada' }}</p>
                    </div>

                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:shadow-sm">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Programa</p>
                        <p class="mt-2 text-base font-bold text-[#0A2334]">{{ optional($courseGroup?->program)->nombre ?? 'Programa no registrado' }}</p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:shadow-sm">
                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Fecha de inicio</p>
                            <p class="mt-2 text-base font-bold text-[#0A2334]">{{ $aprendizData?->fecha_inicio ? \Carbon\Carbon::parse($aprendizData->fecha_inicio)->format('d/m/Y') : 'No registrada' }}</p>
                        </div>

                        <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:shadow-sm">
                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Fecha de fin</p>
                            <p class="mt-2 text-base font-bold text-[#0A2334]">{{ $aprendizData?->fecha_fin ? \Carbon\Carbon::parse($aprendizData->fecha_fin)->format('d/m/Y') : 'No registrada' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
