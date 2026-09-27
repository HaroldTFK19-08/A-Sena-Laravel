@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Perfil Aspirante')

@section('contenido')
    @php
        $aspiranteData = $usuario->aspirant;
    @endphp

    <div class="space-y-8">
        @include('Usuarios.partials.perfilHeader', [
            'tema' => 'aspirante',
            'usuario' => $usuario,
            'eyebrow' => 'Perfil del aspirante',
            'subtitle' => ($aspiranteData?->eps ?? 'EPS no registrada') . ' · ' . ($aspiranteData?->inscriptions->count() ?? 0) . ' inscripción(es)',
            'editRoute' => route('aspirante.edit'),
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
                    <h2 class="text-xl font-extrabold text-[#0A2334]">Datos de admisión</h2>
                    <span class="rounded-full bg-[#FFE9E6] px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-[#B17A79]">Aspirante</span>
                </div>

                <div class="space-y-4">
                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:shadow-sm">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">EPS</p>
                        <p class="mt-2 text-base font-bold text-[#0A2334]">{{ optional($aspiranteData)->eps ?? 'No registrada' }}</p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:shadow-sm">
                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Certificado EPS</p>
                            <p class="mt-2 text-sm font-bold {{ optional($aspiranteData)->certificado_eps ? 'text-[#0E6B54]' : 'text-[#5F7785]' }}">
                                {{ optional($aspiranteData)->certificado_eps ? 'Cargado' : 'No cargado' }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:shadow-sm">
                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Bachiller</p>
                            <p class="mt-2 text-sm font-bold {{ optional($aspiranteData)->certificado_bachiller ? 'text-[#0E6B54]' : 'text-[#5F7785]' }}">
                                {{ optional($aspiranteData)->certificado_bachiller ? 'Cargado' : 'No cargado' }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:shadow-sm">
                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">ICFES</p>
                            <p class="mt-2 text-sm font-bold {{ optional($aspiranteData)->certificado_icfes ? 'text-[#0E6B54]' : 'text-[#5F7785]' }}">
                                {{ optional($aspiranteData)->certificado_icfes ? 'Cargado' : 'No cargado' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
