<div class="space-y-8">
    <!-- Encabezado Principal -->
    <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.08)] md:p-8">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>

        <div class="relative flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Gestión académica</span>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#0A2334] md:text-4xl">{{ $titulo }}</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-[#3B5D6E] md:text-base">
                    Selecciona la competencia correspondiente y define los resultados de aprendizaje para el programa de formación.
                </p>
            </div>
            <a href="{{ route('resultados.index') }}"
                class="inline-flex w-fit items-center gap-2 rounded-xl border border-[#D8E6EB] bg-white/80 px-4 py-2.5 text-sm font-semibold text-[#45616F] shadow-sm backdrop-blur-sm transition-all hover:border-[#8AFD5D] hover:bg-white hover:text-[#234657] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8AFD5D]">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Volver a resultados
            </a>
        </div>
    </section>

    <!-- Formulario -->
    <form method="POST" action="{{ $action }}" class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.06)] md:p-8">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        <!-- Banner de Errores -->
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

            <!-- Competencia -->
            <div>
                <label for="competition_id" class="mb-2 block text-sm font-semibold text-[#234657]">
                    Competencia <span class="text-red-500">*</span>
                </label>
                <select id="competition_id" name="competition_id" required
                        class="w-full rounded-xl border bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition focus:ring-4
                        @error('competition_id') border-red-400 focus:border-red-500 focus:ring-red-100 @else border-[#D8E6EB] focus:border-[#8AFD5D] focus:ring-[#8AFD5D]/20 @enderror">
                    <option value="">Seleccione una competencia</option>
                    @foreach ($competencias as $competencia)
                        <option value="{{ $competencia->id }}" @selected(old('competition_id', $resultado?->competition_id) == $competencia->id)>
                            {{ $competencia->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('competition_id')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Código -->
            <div>
                <label for="codigo" class="mb-2 block text-sm font-semibold text-[#234657]">
                    Código
                </label>
                <input id="codigo" type="text" name="codigo" value="{{ old('codigo', $resultado?->codigo) }}" placeholder="Ej. RA-01"
                       class="w-full rounded-xl border bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition placeholder:text-[#9BAEB7] focus:ring-4
                       @error('codigo') border-red-400 focus:border-red-500 focus:ring-red-100 @else border-[#D8E6EB] focus:border-[#8AFD5D] focus:ring-[#8AFD5D]/20 @enderror">
                @error('codigo')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nombre -->
            <div class="{{ $resultado ? 'md:col-span-2' : '' }}">
                <label for="nombre" class="mb-2 block text-sm font-semibold text-[#234657]">
                    Nombre del Resultado <span class="text-red-500">*</span>
                </label>
                <input id="nombre" type="text" name="nombre" required value="{{ old('nombre', $resultado?->nombre) }}" placeholder="Ej. Identificar requerimientos del sistema"
                       class="w-full rounded-xl border bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition placeholder:text-[#9BAEB7] focus:ring-4
                       @error('nombre') border-red-400 focus:border-red-500 focus:ring-red-100 @else border-[#D8E6EB] focus:border-[#8AFD5D] focus:ring-[#8AFD5D]/20 @enderror">
                @error('nombre')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Cantidad de resultados (Solo al crear) -->
            @unless ($resultado)
                <div>
                    <label for="cantidad" class="mb-2 block text-sm font-semibold text-[#234657]">
                        Cantidad a generar
                    </label>
                    <input id="cantidad" type="number" min="1" max="30" name="cantidad" value="{{ old('cantidad', 1) }}"
                           class="w-full rounded-xl border bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition focus:ring-4
                           @error('cantidad') border-red-400 focus:border-red-500 focus:ring-red-100 @else border-[#D8E6EB] focus:border-[#8AFD5D] focus:ring-[#8AFD5D]/20 @enderror">
                    @error('cantidad')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endunless

            <!-- Descripción -->
            <div class="md:col-span-2">
                <label for="descripcion" class="mb-2 block text-sm font-semibold text-[#234657]">
                    Descripción
                </label>
                <textarea id="descripcion" name="descripcion" rows="4" placeholder="Describe detalladamente el alcance de este resultado de aprendizaje..."
                          class="w-full resize-y rounded-xl border bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition placeholder:text-[#9BAEB7] focus:ring-4
                          @error('descripcion') border-red-400 focus:border-red-500 focus:ring-red-100 @else border-[#D8E6EB] focus:border-[#8AFD5D] focus:ring-[#8AFD5D]/20 @enderror">{{ old('descripcion', $resultado?->descripcion) }}</textarea>
                @error('descripcion')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <!-- Botones de Acción -->
        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-[#D8E6EB] pt-6 sm:flex-row sm:justify-end">
            <a href="{{ route('resultados.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-[#C7D8DE] bg-white px-6 py-3 text-sm font-semibold text-[#45616F] transition hover:border-[#9BAEB7] hover:bg-[#F4F7F2] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300">
                Cancelar
            </a>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#8AFD5D] px-6 py-3 text-sm font-bold text-[#001E30] shadow-[0_8px_20px_rgba(138,253,93,0.25)] transition hover:bg-[#76E94C] hover:shadow-[0_10px_24px_rgba(138,253,93,0.35)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8AFD5D]">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ $resultado ? 'Actualizar resultado' : 'Guardar resultado' }}
            </button>
        </div>
    </form>
</div>