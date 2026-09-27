<form class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-8 shadow-[0_12px_26px_rgba(15,40,53,0.06)] space-y-6" method="POST" action="{{ $action }}">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 text-red-600 border border-red-200 text-sm font-semibold flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-1 1.293a1 1 0 00-1.414-1.414L10 11.586 8.707 10.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ $errors->first() }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="flex flex-col gap-2">
            <label class="text-sm font-bold text-[#4b6473] ml-1">Programa de Formación</label>
            <select name="program_id" required class="w-full px-4 py-3 rounded-2xl border border-[#D8E6EB] bg-white text-[#0A2334] focus:ring-2 focus:ring-[#8AFD5D] focus:border-transparent transition-all outline-none">
                <option value="">Seleccione un programa</option>
                @foreach ($programas as $programa)
                    <option value="{{ $programa->id }}" @selected(old('program_id', $ficha?->program_id) == $programa->id)>{{ $programa->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col gap-2">
            <label class="text-sm font-bold text-[#4b6473] ml-1">Instructor Responsable</label>
            <select name="teacher_id" required class="w-full px-4 py-3 rounded-2xl border border-[#D8E6EB] bg-white text-[#0A2334] focus:ring-2 focus:ring-[#8AFD5D] focus:border-transparent transition-all outline-none">
                <option value="">Seleccione un instructor</option>
                @foreach ($instructores as $instructor)
                    <option value="{{ $instructor->id }}" @selected(old('teacher_id', $ficha?->teacher_id) == $instructor->id)>
                        {{ ($instructor->user?->nombre_1 ?? 'Instructor') }} {{ ($instructor->user?->apellido_1 ?? '') }} — {{ $instructor->area?->nombre ?? 'Sin área' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col gap-2">
            <label class="text-sm font-bold text-[#4b6473] ml-1">Código de la Ficha</label>
            <input name="codigo" value="{{ old('codigo', $ficha?->codigo) }}" required
                   class="w-full px-4 py-3 rounded-2xl border border-[#D8E6EB] bg-white text-[#0A2334] focus:ring-2 focus:ring-[#8AFD5D] focus:border-transparent transition-all outline-none"
                   placeholder="Ej: 254321">
        </div>

        <div class="flex flex-col gap-2">
            <label class="text-sm font-bold text-[#4b6473] ml-1">Capacidad de Aprendices</label>
            <input type="number" min="1" name="capacidad_aprendices"
                   value="{{ old('capacidad_aprendices', $ficha?->capacidad_aprendices) }}" required
                   class="w-full px-4 py-3 rounded-2xl border border-[#D8E6EB] bg-white text-[#0A2334] focus:ring-2 focus:ring-[#8AFD5D] focus:border-transparent transition-all outline-none"
                   placeholder="Ej: 30">
        </div>
    </div>

    <div class="flex justify-end pt-4">
        <button class="px-8 py-3 rounded-2xl bg-[#0E6B54] text-white font-bold transition-all hover:bg-[#0a5a46] shadow-lg hover:shadow-[#0e6b54]/30" type="submit">
            {{ $ficha ? 'Actualizar Ficha' : 'Guardar Ficha' }}
        </button>
    </div>
</form>
