@if ($errors->any())
    <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-600"><p class="font-bold">Revisa los datos ingresados.</p><ul class="mt-2 list-disc space-y-1 pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if ($method === 'PUT') @method('PUT') @endif
    <div class="grid gap-5 md:grid-cols-2">
        <div><label for="nombre" class="form-label">Nombre del área *</label><input id="nombre" name="nombre" value="{{ old('nombre', $area?->nombre) }}" required class="form-input" placeholder="Ej. Sistemas y Computación">@error('nombre')<p class="form-error">{{ $message }}</p>@enderror</div>
        <div><label for="trainingcenter_id" class="form-label">Centro de formación *</label><select id="trainingcenter_id" name="trainingcenter_id" required class="form-input"><option value="">Selecciona un centro</option>@foreach ($centros as $centro)<option value="{{ $centro->id }}" @selected((string) old('trainingcenter_id', $area?->trainingcenter_id) === (string) $centro->id)>{{ $centro->nombre }}</option>@endforeach</select>@error('trainingcenter_id')<p class="form-error">{{ $message }}</p>@enderror</div>
    </div>
    <div class="flex flex-col-reverse gap-3 border-t border-[#E3ECEF] pt-5 sm:flex-row sm:justify-end"><a href="{{ route('areas.index') }}" class="form-cancel">Cancelar</a><button class="form-submit">{{ $method === 'PUT' ? 'Guardar cambios' : 'Guardar área' }}</button></div>
</form>
