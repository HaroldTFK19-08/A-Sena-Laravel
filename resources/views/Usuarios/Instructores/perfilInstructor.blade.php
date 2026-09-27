@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Perfil Instructor')

@section('contenido')

    @php
        $teacherData = $usuario->teacher;
        $area = $teacherData?->area;
        $competencias = $teacherData?->competencies ?? collect();
    @endphp

    <div class="space-y-8">

        @include('Usuarios.partials.perfilHeader', [
            'tema' => 'instructor',
            'usuario' => $usuario,
            'eyebrow' => 'Perfil del instructor',
            'subtitle' => $teacherData?->especialidad ?? 'Especialidad no registrada',
            'badges' => array_filter([$teacherData?->tipo_instructor ?? 'Tipo no definido', $area?->nombre]),
            'editRoute' => route('instructor.edit'),
        ])

        {{-- ============================================================
             INFORMACIÓN PRINCIPAL
        ============================================================= --}}

        <section class="grid gap-6 xl:grid-cols-2">

            {{-- INFORMACIÓN PERSONAL --}}
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

            {{-- DATOS DOCENTES --}}
            <div class="rounded-[28px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">

                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-xl font-extrabold text-[#0A2334]">Datos docentes</h2>
                    @if ($teacherData)
                        <span class="rounded-full bg-[#E8EEFF] px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-[#4B6BC8]">Instructor</span>
                    @endif
                </div>

                <div class="space-y-4">
                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:shadow-sm">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Área</p>
                        <p class="mt-2 text-base font-bold text-[#0A2334]">{{ $area?->nombre ?? 'Área no registrada' }}</p>
                    </div>

                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:shadow-sm">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Especialidad</p>
                        <p class="mt-2 text-base font-bold text-[#0A2334]">{{ $teacherData?->especialidad ?? 'No registrada' }}</p>
                    </div>

                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:shadow-sm">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Tipo de instructor</p>
                        <p class="mt-2 text-base font-bold text-[#0A2334]">{{ $teacherData?->tipo_instructor ?? 'No registrado' }}</p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:shadow-sm">
                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Fecha de inicio</p>
                            <p class="mt-2 text-base font-bold text-[#0A2334]">
                                {{ $teacherData?->fecha_inicio ? \Carbon\Carbon::parse($teacherData->fecha_inicio)->format('d/m/Y') : 'No registrada' }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition hover:shadow-sm">
                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Fecha de fin</p>
                            <p class="mt-2 text-base font-bold text-[#0A2334]">
                                {{ $teacherData?->fecha_fin ? \Carbon\Carbon::parse($teacherData->fecha_fin)->format('d/m/Y') : 'Actualmente activo' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        {{-- ============================================================
             COMPETENCIAS
        ============================================================= --}}

        <section class="rounded-[28px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">

            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-extrabold text-[#0A2334]">Competencias</h2>
                    <p class="mt-1 text-sm text-[#5F7785]">Competencias asociadas al instructor.</p>
                </div>

                <span class="rounded-full bg-[#E8EEFF] px-4 py-2 text-xs font-bold text-[#4B6BC8]">
                    {{ $competencias->count() }} {{ $competencias->count() === 1 ? 'competencia' : 'competencias' }}
                </span>
            </div>

            @if ($competencias->count())
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($competencias as $competencia)
                        <div class="rounded-2xl border border-[#D8E6EB] bg-white p-5 transition duration-200 hover:-translate-y-1 hover:shadow-lg">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E8EEFF] font-black text-[#4B6BC8]">
                                    {{ $loop->iteration }}
                                </div>
                                <span class="rounded-full bg-[#F0F7F5] px-2.5 py-1 text-[9px] font-bold uppercase tracking-[0.15em] text-[#0E6B54]">Activa</span>
                            </div>

                            <h3 class="mt-4 font-extrabold leading-6 text-[#0A2334]">{{ $competencia->nombre }}</h3>

                            @if ($competencia->codigo)
                                <p class="mt-1 text-xs font-semibold text-[#6078B5]">Código: {{ $competencia->codigo }}</p>
                            @endif

                            @if ($competencia->descripcion)
                                <p class="mt-3 text-sm leading-6 text-[#5F7785]">{{ $competencia->descripcion }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-[#C9D9DF] bg-white p-8 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#E8EEFF] text-[#4B6BC8]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                    </div>
                    <p class="mt-4 font-bold text-[#0A2334]">No hay competencias asociadas</p>
                    <p class="mt-1 text-sm text-[#5F7785]">El administrativo lo asociara a las competencias que dictara</p>
                </div>
            @endif

        </section>

    </div>

@endsection
