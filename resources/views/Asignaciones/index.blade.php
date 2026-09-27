@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Asignaciones de Equipos')

@section('contenido')

    <div class="space-y-8">

        {{-- Encabezado --}}
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#EAF5F4] via-[#F1F8F7] to-[#E9F0F7] p-6 md:p-8 shadow-[0_20px_45px_rgba(15,40,53,0.08)]">

            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>

            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">
                        Gestión Académica
                    </p>

                    <h1 class="mt-3 text-3xl md:text-4xl font-black text-[#0A2334] leading-tight">
                        Asignaciones de Equipos
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm md:text-base text-[#3b5d6e] leading-relaxed">
                        Consulta y administra la entrega de herramientas y equipos a los aprendices.
                    </p>

                </div>

                @if($isInstructor && auth()->user()?->teacher)

                    <a href="{{ route('instructor.asignaciones.create') }}"
                       class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-[#0E6B54] text-white font-bold transition-all hover:bg-[#0a5a46] shadow-lg hover:shadow-[#0e6b54]/30">

                        <svg class="w-5 h-5 mr-2"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 4v16m8-8H4"/>

                        </svg>

                        Nueva asignación

                    </a>

                @endif

            </div>

        </section>


        {{-- Mensaje de éxito --}}
        @if(session('success'))

            <div class="p-4 rounded-2xl bg-[#D8F7CB] text-[#0E6B54] border border-[#BCE6B0] text-sm font-semibold flex items-center shadow-sm">

                <svg class="w-5 h-5 mr-3"
                     fill="currentColor"
                     viewBox="0 0 20 20">

                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 0016 0zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                          clip-rule="evenodd">
                    </path>

                </svg>

                {{ session('success') }}

            </div>

        @endif


        {{-- Tarjetas estadísticas --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-5">

            {{-- Total --}}
            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">

                <div class="flex items-center justify-between">

                    <p class="text-sm text-[#4b6473]">
                        Asignaciones
                    </p>

                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">

                        <svg class="w-5 h-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M9 12h6m-6 4h6M7 7h10a2 2 0 012 2v8a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z"/>

                        </svg>

                    </span>

                </div>

                <p class="mt-5 text-3xl font-black text-[#0A2334]">
                    {{ $asignaciones->count() }}
                </p>

                <p class="mt-2 text-xs text-[#5F7785]">
                    Total registrado
                </p>

            </div>


            {{-- Activas --}}
            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">

                <div class="flex items-center justify-between">

                    <p class="text-sm text-[#4b6473]">
                        Activas
                    </p>

                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">

                        <svg class="w-5 h-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M5 13l4 4L19 7"/>

                        </svg>

                    </span>

                </div>

                <p class="mt-5 text-3xl font-black text-[#0A2334]">
                    {{ $asignaciones->where('Estado', 'Activo')->count() }}
                </p>

                <p class="mt-2 text-xs text-[#5F7785]">
                    En uso actualmente
                </p>

            </div>


            {{-- Equipos --}}
            <div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">

                <div class="flex items-center justify-between">

                    <p class="text-sm text-[#4b6473]">
                        Equipos
                    </p>

                    <span class="rounded-xl bg-[#D8F7CB] p-2 text-[#0E6B54]">

                        <svg class="w-5 h-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>

                        </svg>

                    </span>

                </div>

                <p class="mt-5 text-3xl font-black text-[#0A2334]">
                    {{ $asignaciones->pluck('equipment_id')->unique()->count() }}
                </p>

                <p class="mt-2 text-xs text-[#5F7785]">
                    Elementos asignados
                </p>

            </div>

        </section>


        {{-- Tabla --}}
        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">

            <div class="mb-6">

                <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">
                    Listado
                </p>

                <h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">
                    Todas las asignaciones
                </h2>

            </div>


            @if($asignaciones->isEmpty())

                {{-- Sin registros --}}
                <div class="text-center py-12">

                    <p class="text-sm text-[#5F7785]">
                        Aún no hay asignaciones registradas.
                    </p>

                    @if($isInstructor && auth()->user()?->teacher)

                        <a href="{{ route('instructor.asignaciones.create') }}"
                           class="mt-4 inline-flex items-center px-4 py-2 rounded-xl bg-[#0E6B54] text-white text-xs font-bold hover:bg-[#0a5a46] transition-all">

                            Crear la primera

                        </a>

                    @endif

                </div>

            @else

                {{-- Tabla de asignaciones --}}
                <div class="overflow-x-auto">

                    <table class="w-full text-left border-collapse">

                        <thead class="text-sm text-[#4b6473]">

                            <tr class="border-b border-[#D8E6EB]">

                                <th class="py-4 px-4 font-semibold uppercase tracking-wider">
                                    Aprendiz
                                </th>

                                <th class="py-4 px-4 font-semibold uppercase tracking-wider">
                                    Equipo
                                </th>

                                <th class="py-4 px-4 font-semibold uppercase tracking-wider">
                                    Fecha asignación
                                </th>

                                <th class="py-4 px-4 font-semibold uppercase tracking-wider">
                                    Estado
                                </th>

                                <th class="py-4 px-4 font-semibold uppercase tracking-wider text-right">
                                    Acciones
                                </th>

                            </tr>

                        </thead>


                        <tbody class="text-sm text-[#0A2334]">

                            @foreach($asignaciones as $asignacion)

                                <tr class="border-b border-[#D8E6EB]/50 hover:bg-[#F1F8F7] transition-colors">

                                    {{-- Aprendiz --}}
                                    <td class="py-4 px-4">

                                        <div class="flex items-center">

                                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#D8F7CB] text-[#0E6B54] font-bold mr-3 text-xs">
                                                A
                                            </span>

                                            <b class="font-medium">
                                                {{ $asignacion->apprentice?->user?->nombre_completo ?? 'Sin aprendiz' }}
                                            </b>

                                        </div>

                                    </td>


                                    {{-- Equipo --}}
                                    <td class="py-4 px-4">

                                        {{ $asignacion->equipment?->name ?? 'Sin equipo' }}

                                    </td>


                                    {{-- Fecha --}}
                                    <td class="py-4 px-4">

                                        {{ $asignacion->fecha_asignacion?->format('d/m/Y') }}

                                    </td>


                                    {{-- Estado --}}
                                    <td class="py-4 px-4">

                                        <span class="rounded-full px-3 py-1 text-xs font-bold {{ $asignacion->Estado === 'Activo' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">

                                            {{ $asignacion->Estado }}

                                        </span>

                                    </td>


                                    {{-- Acciones --}}
                                    <td class="py-4 px-4 text-right space-x-2">

                                        {{-- Ver --}}
                                        <a href="{{ route($baseRoute.'.show', $asignacion) }}"
                                           class="inline-flex items-center px-3 py-1.5 rounded-lg bg-white border border-[#D8E6EB] text-xs font-semibold text-[#4b6473] hover:bg-[#F1F8F7] transition-all">

                                            Ver

                                        </a>


                                        @if($isInstructor)

                                            {{-- Editar --}}
                                            <a href="{{ route('instructor.asignaciones.edit', $asignacion) }}"
                                               class="inline-flex items-center px-3 py-1.5 rounded-lg bg-white border border-[#D8E6EB] text-xs font-semibold text-[#4b6473] hover:bg-[#F1F8F7] transition-all">

                                                Editar

                                            </a>


                                            {{-- Eliminar --}}
                                            <form method="POST"
                                                  action="{{ route('instructor.asignaciones.destroy', $asignacion) }}"
                                                  onsubmit="return confirm('¿Eliminar esta asignación?');"
                                                  class="inline">

                                                @csrf

                                                @method('DELETE')

                                                <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 rounded-lg bg-white border border-red-200 text-xs font-semibold text-red-500 hover:bg-red-50 transition-all">

                                                    Eliminar

                                                </button>

                                            </form>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </section>

    </div>

@endsection