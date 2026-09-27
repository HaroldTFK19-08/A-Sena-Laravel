@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Detalle del Ambiente')

@section('contenido')

    <div class="space-y-8">

        {{-- Encabezado --}}
        <section
            class="rounded-[30px] border border-[#D8E6EB] bg-gradient-to-r from-[#EAF6F4] via-[#F4F9FB] to-[#F0F5FF] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.08)] md:p-8"
        >
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                <div class="flex items-center gap-5">

                    <div
                        class="flex h-20 w-20 items-center justify-center rounded-2xl bg-[#0E6B54] text-2xl font-black text-white"
                    >
                        {{ strtoupper(substr($ambiente->nombre, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#1B5E6A]">
                            Ambiente de formación
                        </p>
                        <h1 class="mt-2 text-3xl font-black text-[#0A2334]">
                            {{ $ambiente->nombre }}
                        </h1>
                        <p class="mt-1 text-sm text-[#5F7785]">
                            {{ $ambiente->trainingcenter?->nombre ?? 'Sin centro asignado' }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <a
                        href="{{ route('ambientes.edit', $ambiente->id) }}"
                        class="inline-flex items-center justify-center rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30]"
                    >
                        Editar ambiente
                    </a>
                    <a
                        href="{{ route('ambientes.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-[#C7DCE2] bg-white/70 px-5 py-3 text-sm font-semibold text-[#0A2334]"
                    >
                        Volver al listado
                    </a>
                </div>
            </div>
        </section>
        {{-- Tarjetas principales --}}
        <section class="grid gap-5 md:grid-cols-3">
            {{-- Capacidad --}}
            <div
                class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]"
            >
                <p class="text-sm text-[#4b6473]">
                    Capacidad
                </p>
                <p class="mt-4 text-3xl font-black text-[#0A2334]">
                    {{ $ambiente->capacidad }}
                </p>
                <p class="mt-2 text-xs text-[#5F7785]">
                    Personas
                </p>
            </div>
            {{-- Tipo --}}
            <div
                class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]"
            >
                <p class="text-sm text-[#4b6473]">
                    Tipo
                </p>
                <p class="mt-4 text-2xl font-black text-[#0A2334]">
                    {{ $ambiente->tipo_ambiente }}
                </p>
                <p class="mt-2 text-xs text-[#5F7785]">
                    Categoría del espacio
                </p>
            </div>
        </section>
        {{-- Información y acciones --}}
        <section class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">

            {{-- Información general --}}
            <div
                class="rounded-[28px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]"
            >
                <h2 class="text-xl font-extrabold text-[#0A2334]">
                    Información general
                </h2>

                <div class="mt-5 grid gap-4 md:grid-cols-2">

                    {{-- Nombre --}}
                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">
                            Nombre
                        </p>

                        <p class="mt-2 font-bold text-[#0A2334]">
                            {{ $ambiente->nombre }}
                        </p>
                    </div>
                    {{-- Centro --}}
                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">
                            Centro
                        </p>
                        <p class="mt-2 font-bold text-[#0A2334]">
                            {{ $ambiente->trainingcenter?->nombre ?? 'Sin centro' }}
                        </p>
                    </div>
                    {{-- Fecha de creación --}}
                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">
                            Registrado el
                        </p>
                        <p class="mt-2 font-bold text-[#0A2334]">
                            {{ $ambiente->created_at?->translatedFormat('d M Y') }}
                        </p>
                    </div>
                    {{-- Fecha de actualización --}}
                    <div class="rounded-2xl border border-[#D8E6EB] bg-white p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">
                            Actualizado el
                        </p>
                        <p class="mt-2 font-bold text-[#0A2334]">
                            {{ $ambiente->updated_at?->translatedFormat('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
            {{-- Acciones --}}
            <div
                class="rounded-[28px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]"
            >
                <h2 class="text-xl font-extrabold text-[#0A2334]">
                    Acciones
                </h2>
                <div class="mt-5 space-y-3">
                    {{-- Editar --}}
                    <a
                        href="{{ route('ambientes.edit', $ambiente->id) }}"
                        class="flex items-center justify-between rounded-2xl border border-[#D8E6EB] bg-white p-4 text-sm font-bold text-[#0A2334] hover:bg-[#F4FFF1]"
                    >
                        Editar información
                        <span>
                            →
                        </span>
                    </a>
                    {{-- Eliminar --}}
                    <form
                        action="{{ route('ambientes.destroy', $ambiente->id) }}"
                        method="POST"
                        onsubmit="return confirm('¿Eliminar este ambiente?');"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="flex w-full items-center justify-between rounded-2xl border border-rose-200 bg-white p-4 text-sm font-bold text-rose-500 hover:bg-rose-50"
                        >
                            Eliminar ambiente
                            <span>
                                ×
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection