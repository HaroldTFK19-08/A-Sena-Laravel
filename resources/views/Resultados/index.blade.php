@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Resultados de aprendizaje')

@section('contenido')
    <div class="space-y-8">
        <!-- Encabezado Principal -->
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.08)] md:p-8">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>

            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Gestión académica</span>
                    <h1 class="mt-2 text-3xl font-black text-[#0A2334] md:text-4xl">Resultados de aprendizaje</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#3B5D6E] md:text-base">
                        Configura los criterios de cada competencia. Las calificaciones son gestionadas directamente por el instructor.
                    </p>
                </div>
                <a href="{{ route('resultados.create') }}" 
                   class="inline-flex w-fit shrink-0 items-center gap-2 rounded-xl bg-[#8AFD5D] px-6 py-3.5 text-sm font-extrabold text-[#001E30] shadow-[0_8px_20px_rgba(138,253,93,0.25)] transition hover:bg-[#76E94C] hover:shadow-[0_10px_24px_rgba(138,253,93,0.35)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8AFD5D]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Nuevo resultado
                </a>
            </div>
        </section>

        <!-- Mensajes Flash -->
        @if (session('success'))
            <div class="flex items-center gap-3 rounded-2xl border border-[#BFE6B1] bg-[#EAFBF0] p-4 text-sm font-semibold text-[#0E6B54]">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-center gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-600">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Tarjetas de Resumen KPI -->
        <section class="grid grid-cols-2 gap-4 md:grid-cols-4">
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-sm transition hover:bg-white">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#5F7785]">Configurados</p>
                <p class="mt-2 text-3xl font-black text-[#0A2334]">{{ $resumen['total_resultados'] }}</p>
            </div>
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-sm transition hover:bg-white">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#5F7785]">Calificaciones</p>
                <p class="mt-2 text-3xl font-black text-[#0A2334]">{{ $resumen['total_calificaciones'] }}</p>
            </div>
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-sm transition hover:bg-white">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#5F7785]">Aprobadas</p>
                <p class="mt-2 text-3xl font-black text-[#0E6B54]">{{ $resumen['aprobados'] }}</p>
            </div>
            <div class="rounded-[22px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-sm transition hover:bg-white">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#5F7785]">Pendientes</p>
                <p class="mt-2 text-3xl font-black text-amber-600">{{ $resumen['pendientes'] }}</p>
            </div>
        </section>

        <!-- Bloque de Tabla y Búsqueda -->
        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.06)] md:p-8">
            
            <!-- Barra de Filtros -->
            <form method="GET" class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-[1fr_260px_auto_auto]">
                <div class="relative">
                    <input type="search" name="buscar" value="{{ request('buscar') }}" 
                           placeholder="Buscar por nombre, código o competencia..."
                           class="h-12 w-full rounded-2xl border border-[#D8E6EB] bg-white px-4 text-sm text-[#0A2334] outline-none transition placeholder:text-[#9BAEB7] focus:border-[#8AFD5D] focus:ring-4 focus:ring-[#8AFD5D]/20">
                </div>

                <select name="competencia" 
                        class="h-12 rounded-2xl border border-[#D8E6EB] bg-white px-4 text-sm text-[#0A2334] outline-none transition focus:border-[#8AFD5D] focus:ring-4 focus:ring-[#8AFD5D]/20">
                    <option value="">Todas las competencias</option>
                    @foreach ($competencias as $competencia)
                        <option value="{{ $competencia->id }}" @selected(request('competencia') == $competencia->id)>
                            {{ $competencia->nombre }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" 
                        class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl bg-[#0E6B54] px-6 text-sm font-bold text-white transition hover:bg-[#0A5341] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0E6B54]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Filtrar
                </button>

                @if(request('buscar') || request('competencia'))
                    <a href="{{ route('resultados.index') }}" 
                       class="inline-flex h-12 items-center justify-center rounded-2xl border border-[#D8E6EB] bg-white px-4 text-sm font-semibold text-[#5F7785] transition hover:bg-gray-100">
                        Limpiar
                    </a>
                @endif
            </form>

            <!-- Tabla de Resultados -->
            @if ($resultados->isEmpty())
                <div class="rounded-2xl border border-dashed border-[#D8E6EB] bg-white p-12 text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EAF6F4] text-[#0E6B54]">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-[#0A2334]">No se encontraron resultados</h3>
                    <p class="mt-1 text-sm text-[#5F7785]">Intenta ajustar tus criterios de búsqueda o registra un nuevo resultado de aprendizaje.</p>
                </div>
            @else
                <div class="overflow-hidden rounded-2xl border border-[#D8E6EB] bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-[#D8E6EB] bg-[#F2F7F9] text-xs font-bold uppercase tracking-wider text-[#4B6473]">
                                    <th class="py-4 px-5">Código</th>
                                    <th class="py-4 px-5">Resultado de Aprendizaje</th>
                                    <th class="py-4 px-5">Competencia Asociada</th>
                                    <th class="py-4 px-5 text-center">Notas</th>
                                    <th class="py-4 px-5 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#D8E6EB]/60 text-sm">
                                @foreach ($resultados as $resultado)
                                    <tr class="transition hover:bg-[#F8FCFD]">
                                        <td class="py-4 px-5">
                                            <span class="inline-block rounded-lg bg-[#EAF6F4] px-2.5 py-1 text-xs font-bold text-[#0E6B54]">
                                                {{ $resultado->codigo ?: 'SIN CÓDIGO' }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-5 font-bold text-[#0A2334]">
                                            {{ $resultado->nombre }}
                                        </td>
                                        <td class="py-4 px-5 text-[#3B5D6E]">
                                            {{ $resultado->competition?->nombre ?? 'Sin competencia asignada' }}
                                        </td>
                                        <td class="py-4 px-5 text-center">
                                            <span class="inline-flex items-center justify-center rounded-full bg-gray-100 px-3 py-1 text-xs font-extrabold text-[#0A2334]">
                                                {{ $resultado->grades_count }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-5 text-right">
                                            <div class="inline-flex items-center gap-1.5">
                                                <a href="{{ route('resultados.show', $resultado) }}" 
                                                   title="Ver detalles"
                                                   class="rounded-xl border border-[#D8E6EB] bg-white p-2 text-[#45616F] transition hover:border-[#0E6B54] hover:bg-[#EAF6F4] hover:text-[#0E6B54]">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                
                                                <a href="{{ route('resultados.edit', $resultado) }}" 
                                                   title="Editar registro"
                                                   class="rounded-xl border border-[#D8E6EB] bg-white p-2 text-[#45616F] transition hover:border-[#8AFD5D] hover:bg-[#F2FDF0] hover:text-[#234657]">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>

                                                <form method="POST" action="{{ route('resultados.destroy', $resultado) }}" 
                                                      onsubmit="return confirm('¿Seguro que deseas eliminar este resultado de aprendizaje?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            title="Eliminar"
                                                            class="rounded-xl border border-red-200 bg-white p-2 text-red-500 transition hover:border-red-400 hover:bg-red-50 hover:text-red-600">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Paginación -->
                <div class="mt-6">
                    {{ $resultados->appends(request()->query())->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection