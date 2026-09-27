<div class="space-y-8">

    <!-- Encabezado Principal -->
    <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.08)] md:p-8">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>

        <div class="relative flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div>
                <span class="text-sm font-semibold uppercase tracking-[0.18em] text-[#1B5E6A]">
                    Gestión académica
                </span>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#0A2334] md:text-4xl">
                    {{ $competencia ? 'Editar competencia' : 'Nueva competencia' }}
                </h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-[#3B5D6E] md:text-base">
                    {{ $competencia
                        ? 'Actualiza la información de la competencia seleccionada.'
                        : 'Registra una nueva competencia académica para organizar la información de formación.' }}
                </p>
            </div>
            <a href="{{ route('competencias.index') }}"
                class="inline-flex w-fit items-center gap-2 rounded-xl border border-[#D8E6EB] bg-white/80 px-4 py-2.5 text-sm font-semibold text-[#45616F] shadow-sm backdrop-blur-sm transition-all hover:border-[#8AFD5D] hover:bg-white hover:text-[#234657] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8AFD5D]">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Competencias
            </a>
        </div>
    </section>

    <!-- Formulario -->
    <form method="POST" action="{{ $action }}"
            class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.06)] md:p-8">

        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        <!-- Banner de Errores General -->
        @if ($errors->any())
            <div class="mb-8 flex gap-3 rounded-2xl border border-[#F1B8B8] bg-[#FFF5F5] p-4 text-sm text-[#A33A3A]">
                <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86l-8.18 14A2 2 0 003.84 21h16.32a2 2 0 001.73-3.14l-8.18-14a2 2 0 00-3.42 0z" />
                </svg>

                <div>
                    <p class="font-semibold">Por favor revisa los siguientes errores:</p>
                    <ul class="mt-1 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Grilla del Formulario -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            <!-- Nombre -->
            <div>
                <label for="nombre" class="mb-2 block text-sm font-semibold text-[#234657]">
                    Nombre <span class="text-red-500">*</span>
                </label>

                <input id="nombre"
                        type="text"
                        name="nombre"
                        value="{{ old('nombre', $competencia?->nombre) }}"
                        required
                        placeholder="Ej. Gestión de bases de datos"
                        class="w-full rounded-xl border bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition placeholder:text-[#9BAEB7] focus:ring-4
                        @error('nombre') border-red-400 focus:border-red-500 focus:ring-red-100 @else border-[#D8E6EB] focus:border-[#8AFD5D] focus:ring-[#8AFD5D]/20 @enderror">

                @error('nombre')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Código -->
            <div>
                <label for="codigo" class="mb-2 block text-sm font-semibold text-[#234657]">
                    Código
                </label>

                <input id="codigo"
                       type="text"
                       name="codigo"
                       value="{{ old('codigo', $competencia?->codigo) }}"
                       placeholder="Ej. 220501001"
                       class="w-full rounded-xl border bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition placeholder:text-[#9BAEB7] focus:ring-4
                       @error('codigo') border-red-400 focus:border-red-500 focus:ring-red-100 @else border-[#D8E6EB] focus:border-[#8AFD5D] focus:ring-[#8AFD5D]/20 @enderror">

                @error('codigo')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Instructor -->
            <div>
                <label for="instructor_id" class="mb-2 block text-sm font-semibold text-[#234657]">
                    Instructor
                </label>

                <select id="instructor_id"
                        name="instructor_id"
                        class="w-full rounded-xl border bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition focus:ring-4
                        @error('instructor_id') border-red-400 focus:border-red-500 focus:ring-red-100 @else border-[#D8E6EB] focus:border-[#8AFD5D] focus:ring-[#8AFD5D]/20 @enderror">

                    <option value="">Sin asignar</option>

                    @foreach ($instructores as $instructor)
                        @php
                            $nombreCompleto = implode(' ', array_filter([
                                $instructor->user?->nombre_1,
                                $instructor->user?->apellido_1
                            ]));
                        @endphp
                        <option value="{{ $instructor->id }}"
                            @selected(old('instructor_id', $competencia?->instructor_id) == $instructor->id)>
                            {{ $nombreCompleto ?: 'Instructor ' . $instructor->id }}
                        </option>
                    @endforeach
                </select>

                @error('instructor_id')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fecha Inicio -->
            <div>
                <label for="fecha_inicio" class="mb-2 block text-sm font-semibold text-[#234657]">
                    Fecha de inicio <span class="text-red-500">*</span>
                </label>

                <input id="fecha_inicio"
                       type="date"
                       name="fecha_inicio"
                       value="{{ old('fecha_inicio', $competencia?->fecha_inicio?->format('Y-m-d') ?? $competencia?->fecha_inicio) }}"
                       required
                       class="w-full rounded-xl border bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition focus:ring-4
                       @error('fecha_inicio') border-red-400 focus:border-red-500 focus:ring-red-100 @else border-[#D8E6EB] focus:border-[#8AFD5D] focus:ring-[#8AFD5D]/20 @enderror">

                @error('fecha_inicio')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fecha Fin -->
            <div>
                <label for="fecha_fin" class="mb-2 block text-sm font-semibold text-[#234657]">
                    Fecha de finalización <span class="text-red-500">*</span>
                </label>

                <input id="fecha_fin"
                       type="date"
                       name="fecha_fin"
                       value="{{ old('fecha_fin', $competencia?->fecha_fin?->format('Y-m-d') ?? $competencia?->fecha_fin) }}"
                       required
                       class="w-full rounded-xl border bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition focus:ring-4
                       @error('fecha_fin') border-red-400 focus:border-red-500 focus:ring-red-100 @else border-[#D8E6EB] focus:border-[#8AFD5D] focus:ring-[#8AFD5D]/20 @enderror">

                @error('fecha_fin')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descripción -->
            <div class="md:col-span-2">
                <label for="descripcion" class="mb-2 block text-sm font-semibold text-[#234657]">
                    Descripción
                </label>

                <textarea id="descripcion"
                          name="descripcion"
                          rows="4"
                          placeholder="Describe brevemente el propósito de esta competencia..."
                          class="w-full resize-y rounded-xl border bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition placeholder:text-[#9BAEB7] focus:ring-4
                          @error('descripcion') border-red-400 focus:border-red-500 focus:ring-red-100 @else border-[#D8E6EB] focus:border-[#8AFD5D] focus:ring-[#8AFD5D]/20 @enderror">{{ old('descripcion', $competencia?->descripcion) }}</textarea>

                @error('descripcion')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <!-- Botones de Acción -->
        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-[#D8E6EB] pt-6 sm:flex-row sm:justify-end">
            <a href="{{ route('competencias.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-[#C7D8DE] bg-white px-6 py-3 text-sm font-semibold text-[#45616F] transition hover:border-[#9BAEB7] hover:bg-[#F4F7F2] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300">
                Cancelar
            </a>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#8AFD5D] px-6 py-3 text-sm font-bold text-[#001E30] shadow-[0_8px_20px_rgba(138,253,93,0.25)] transition hover:bg-[#76E94C] hover:shadow-[0_10px_24px_rgba(138,253,93,0.35)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8AFD5D]">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ $competencia ? 'Actualizar competencia' : 'Guardar competencia' }}
            </button>
        </div>

    </form>
</div>