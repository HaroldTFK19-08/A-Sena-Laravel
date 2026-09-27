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

<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label for="nombre" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#0A2334]">Nombre del ambiente *</label>
            <input id="nombre" name="nombre" type="text" value="{{ old('nombre', $ambiente?->nombre) }}" required placeholder="Ej. Ambiente de Software 301" class="w-full rounded-xl border border-[#D8E6EB] bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54]">
            @error('nombre')<p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="trainingcenter_id" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#0A2334]">Centro de formación *</label>
            <select id="trainingcenter_id" name="trainingcenter_id" required class="w-full rounded-xl border border-[#D8E6EB] bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54]">
                <option value="">Selecciona un centro</option>
                @foreach ($centros as $centro)
                    <option value="{{ $centro->id }}" @selected((string) old('trainingcenter_id', $ambiente?->trainingcenter_id) === (string) $centro->id)>{{ $centro->nombre }}</option>
                @endforeach
            </select>
            @error('trainingcenter_id')<p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="tipo_ambiente" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#0A2334]">Tipo de ambiente *</label>
            <select id="tipo_ambiente" name="tipo_ambiente" required class="w-full rounded-xl border border-[#D8E6EB] bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54]">
                <option value="">Selecciona un tipo</option>
                @foreach (['Software', 'TICS', 'Laboratorio', 'Cocina'] as $tipo)
                    <option value="{{ $tipo }}" @selected(old('tipo_ambiente', $ambiente?->tipo_ambiente) === $tipo)>{{ $tipo }}</option>
                @endforeach
            </select>
            @error('tipo_ambiente')<p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="capacidad" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#0A2334]">Capacidad *</label>
            <input id="capacidad" name="capacidad" type="number" min="1" value="{{ old('capacidad', $ambiente?->capacidad) }}" required placeholder="Ej. 30" class="w-full rounded-xl border border-[#D8E6EB] bg-white px-4 py-3 text-sm text-[#0A2334] outline-none transition focus:border-[#0E6B54] focus:ring-1 focus:ring-[#0E6B54]">
            @error('capacidad')<p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="flex flex-col-reverse gap-3 border-t border-[#E3ECEF] pt-5 sm:flex-row sm:justify-end">
        <a href="{{ route('ambientes.index') }}" class="inline-flex items-center justify-center rounded-xl border border-[#C7DCE2] bg-white px-5 py-3 text-sm font-semibold text-[#0A2334] transition hover:bg-[#F0F5F7]">Cancelar</a>
        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#8AFD5D] px-6 py-3 text-sm font-extrabold text-[#001E30] shadow-lg shadow-[#8AFD5D]/20 transition-transform hover:-translate-y-0.5">{{ $method === 'PUT' ? 'Guardar cambios' : 'Guardar ambiente' }}</button>
    </div>
</form>
