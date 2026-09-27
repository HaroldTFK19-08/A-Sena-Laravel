@if ($errors->any())
    <div class="p-4 rounded-2xl bg-red-50 text-red-600 border border-red-200 text-sm font-semibold flex items-center shadow-sm mb-6">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-1 1.293a1 1 0 00-1.414-1.414L10 11.586 8.707 10.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        <span>Revisa los datos ingresados: {{ $errors->first() }}</span>
    </div>
@endif

<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="grid gap-6 md:grid-cols-2">
        <div class="flex flex-col gap-2">
            <label for="equipment_id" class="text-sm font-bold text-[#4b6473] ml-1">Equipo *</label>
            <select id="equipment_id" name="equipment_id" required class="w-full px-4 py-3 rounded-2xl border border-[#D8E6EB] bg-white text-[#0A2334] focus:ring-2 focus:ring-[#8AFD5D] focus:border-transparent transition-all outline-none">
                <option value="">Selecciona un equipo</option>
                @foreach ($equipos as $equipo)
                    <option value="{{ $equipo->id }}" @selected((string) old('equipment_id', $assignment?->equipment_id) === (string) $equipo->id)>
                        {{ $equipo->name }} - {{ $equipo->environment?->nombre ?? 'Sin ambiente' }}
                    </option>
                @endforeach
            </select>
            @error('equipment_id')
                <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-2">
            <label for="apprentice_id" class="text-sm font-bold text-[#4b6473] ml-1">Aprendiz *</label>
            <select id="apprentice_id" name="apprentice_id" required class="w-full px-4 py-3 rounded-2xl border border-[#D8E6EB] bg-white text-[#0A2334] focus:ring-2 focus:ring-[#8AFD5D] focus:border-transparent transition-all outline-none">
                <option value="">Selecciona un aprendiz</option>
                @foreach ($aprendices as $aprendiz)
                    <option value="{{ $aprendiz->id }}" @selected((string) old('apprentice_id', $assignment?->apprentice_id) === (string) $aprendiz->id)>
                        Aprendiz #{{ $aprendiz->id }}
                        @if($aprendiz->coursegroup)
                            - {{ $aprendiz->coursegroup->nombre ?? 'Ficha '.$aprendiz->coursegroup->id }}
                        @endif
                    </option>
                @endforeach
            </select>
            @error('apprentice_id')
                <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-2">
            <label for="fecha_asignacion" class="text-sm font-bold text-[#4b6473] ml-1">Fecha de asignación *</label>
            <input id="fecha_asignacion" name="fecha_asignacion" type="date" value="{{ old('fecha_asignacion', $assignment?->fecha_asignacion?->format('Y-m-d')) }}" required class="w-full px-4 py-3 rounded-2xl border border-[#D8E6EB] bg-white text-[#0A2334] focus:ring-2 focus:ring-[#8AFD5D] focus:border-transparent transition-all outline-none">
            @error('fecha_asignacion')
                <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-2">
            <label for="fecha_devolucion" class="text-sm font-bold text-[#4b6473] ml-1">Fecha de devolución</label>
            <input id="fecha_devolucion" name="fecha_devolucion" type="date" value="{{ old('fecha_devolucion', $assignment?->fecha_devolucion?->format('Y-m-d')) }}" class="w-full px-4 py-3 rounded-2xl border border-[#D8E6EB] bg-white text-[#0A2334] focus:ring-2 focus:ring-[#8AFD5D] focus:border-transparent transition-all outline-none">
            @error('fecha_devolucion')
                <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="md:col-span-2 flex flex-col gap-2">
            <label for="Estado" class="text-sm font-bold text-[#4b6473] ml-1">Estado *</label>
            <select id="Estado" name="Estado" required class="w-full px-4 py-3 rounded-2xl border border-[#D8E6EB] bg-white text-[#0A2334] focus:ring-2 focus:ring-[#8AFD5D] focus:border-transparent transition-all outline-none">
                <option value="">Selecciona un estado</option>
                <option value="Activo" @selected(old('Estado', $assignment?->Estado) === 'Activo')>Activo</option>
                <option value="Inactivo" @selected(old('Estado', $assignment?->Estado) === 'Inactivo')>Inactivo</option>
            </select>
            @error('Estado')
                <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex flex-col-reverse gap-3 border-t border-[#E3ECEF] pt-6 sm:flex-row sm:justify-end">
        <a href="{{ route('instructor.asignaciones.index') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-white text-[#0A2334] font-bold transition-all border border-[#D8E6EB] hover:bg-[#F1F8F7] shadow-sm">Cancelar</a>
        <button type="submit" class="px-8 py-3 rounded-2xl bg-[#0E6B54] text-white font-bold transition-all hover:bg-[#0a5a46] shadow-lg hover:shadow-[#0e6b54]/30">
            {{ $method === 'PUT' ? 'Guardar cambios' : 'Registrar asignación' }}
        </button>
    </div>
</form>
