@if ($errors->any())
    <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-600">
        <p class="font-bold">Revisa los datos ingresados.</p>
        <ul class="mt-2 list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ $action }}" method="POST" class="space-y-6">@csrf @if ($method === 'PUT')
        @method('PUT')
    @endif
    <div class="grid gap-5 md:grid-cols-2">
        <div><label for="name" class="form-label">Nombre del equipo *</label><input id="name" name="name"
                value="{{ old('name', $equipo?->name) }}" required class="form-input"
                placeholder="Ej. Computador de escritorio">
            @error('name')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>
        <div><label for="brand" class="form-label">Marca</label><input id="brand" name="brand"
                value="{{ old('brand', $equipo?->brand) }}" class="form-input" placeholder="Ej. Lenovo">
            @error('brand')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>
        <div><label for="equipment_type" class="form-label">Tipo de equipo *</label><input id="equipment_type"
                name="equipment_type" value="{{ old('equipment_type', $equipo?->equipment_type) }}" required
                class="form-input" placeholder="Ej. Computación">
            @error('equipment_type')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>
        <div><label for="environment_id" class="form-label">Ambiente *</label><select id="environment_id"
                name="environment_id" required class="form-input">
                <option value="">Selecciona un ambiente</option>
                @foreach ($ambientes as $ambiente)
                    <option value="{{ $ambiente->id }}" @selected((string) old('environment_id', $equipo?->environment_id) === (string) $ambiente->id)>{{ $ambiente->nombre }} ·
                        {{ $ambiente->trainingcenter?->nombre ?? 'Sin centro' }}</option>
                @endforeach
            </select>
            @error('environment_id')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="flex flex-col-reverse gap-3 border-t border-[#E3ECEF] pt-5 sm:flex-row sm:justify-end">
        <a href="{{ route('equipos.index') }}" class="form-cancel">Cancelar</a>
        <button class="form-submit">{{ $method === 'PUT' ? 'Guardar cambios' : 'Guardar equipo' }}</button>
    </div>
</form>
