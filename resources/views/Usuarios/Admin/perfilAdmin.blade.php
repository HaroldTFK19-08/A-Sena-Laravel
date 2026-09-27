@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Perfil Admin')

@section('contenido')

    @php
        $adminData = $usuario->admin;

        $cargo = optional($adminData)->cargo ?? 'Cargo no registrado';
        $ubicacion = optional($adminData)->ubicacion_oficina ?? 'Ubicación sin definir';
        $direccion = optional($adminData)->direccion ?? 'No registrada';
    @endphp

    <div class="space-y-8">

        {{-- ==========================================================
            ENCABEZADO DEL PERFIL
        =========================================================== --}}
        @include('Usuarios.partials.perfilHeader', [
            'tema' => 'admin',
            'usuario' => $usuario,
            'eyebrow' => 'Perfil del administrador',
            'subtitle' => $cargo . ' · ' . $ubicacion,
            'editRoute' => route('admin.edit'),
        ])


        {{-- ==========================================================
            INFORMACIÓN DEL USUARIO
        =========================================================== --}}
        <section class="grid gap-6 xl:grid-cols-2">

            {{-- ======================================================
                INFORMACIÓN PERSONAL
            ======================================================= --}}
            <div
                class="rounded-[28px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]"
            >

                <div class="mb-6 flex items-center justify-between gap-4">

                    <h2 class="text-xl font-extrabold text-[#0A2334]">
                        Información personal
                    </h2>

                    <span
                        class="shrink-0 rounded-full bg-[#D8F7CB] px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-[#0E6B54]"
                    >
                        Cuenta
                    </span>

                </div>


                <div class="grid gap-4 md:grid-cols-2">

                    {{-- TIPO DE IDENTIFICACIÓN --}}
                    <div
                        class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm"
                    >
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">
                            Tipo de identificación
                        </p>

                        <p class="mt-2 text-base font-bold text-[#0A2334]">
                            {{ $usuario->tipo_identificacion ?? 'No registrado' }}
                        </p>
                    </div>


                    {{-- IDENTIFICACIÓN --}}
                    <div
                        class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm"
                    >
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">
                            Identificación
                        </p>

                        <p class="mt-2 text-base font-bold text-[#0A2334]">
                            {{ $usuario->identificacion ?? 'No registrado' }}
                        </p>
                    </div>


                    {{-- CORREO --}}
                    <div
                        class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm"
                    >
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">
                            Correo electrónico
                        </p>

                        <p class="mt-2 break-all text-sm font-bold text-[#0A2334]">
                            {{ $usuario->email ?? 'No registrado' }}
                        </p>
                    </div>


                    {{-- ROL --}}
                    <div
                        class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm"
                    >
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">
                            Rol
                        </p>

                        <p class="mt-2 text-base font-bold text-[#0A2334]">
                            {{ ucfirst($usuario->rol ?? 'Sin rol') }}
                        </p>
                    </div>

                </div>

            </div>


            {{-- ======================================================
                DATOS INSTITUCIONALES
            ======================================================= --}}
            <div
                class="rounded-[28px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]"
            >

                <div class="mb-6 flex items-center justify-between gap-4">

                    <h2 class="text-xl font-extrabold text-[#0A2334]">
                        Datos institucionales
                    </h2>

                    <span
                        class="shrink-0 rounded-full bg-[#EAF6F4] px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-[#1B5E6A]"
                    >
                        Administración
                    </span>

                </div>


                <div class="space-y-4">

                    {{-- CARGO --}}
                    <div
                        class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm"
                    >
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">
                            Cargo
                        </p>

                        <p class="mt-2 text-base font-bold text-[#0A2334]">
                            {{ $cargo }}
                        </p>
                    </div>


                    {{-- UBICACIÓN --}}
                    <div
                        class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm"
                    >
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">
                            Ubicación de oficina
                        </p>

                        <p class="mt-2 text-base font-bold text-[#0A2334]">
                            {{ $ubicacion }}
                        </p>
                    </div>


                    {{-- DIRECCIÓN --}}
                    <div
                        class="rounded-2xl border border-[#D8E6EB] bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm"
                    >
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">
                            Dirección
                        </p>

                        <p class="mt-2 text-base font-bold text-[#0A2334]">
                            {{ $direccion }}
                        </p>
                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection
