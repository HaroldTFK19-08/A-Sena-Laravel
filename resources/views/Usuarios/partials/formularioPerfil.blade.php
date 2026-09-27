@php
    $rol = $rol ?? 'Perfil';
    $color = $color ?? '#8AFD5D';
@endphp

@if ($errors->any())
    <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        <p class="font-bold">Revisa los datos ingresados.</p>
        <ul class="mt-2 list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="rounded-2xl border border-[#BFE6B1] bg-[#F1FAEE] p-4 text-sm font-semibold text-[#0E6B54]">
        {{ session('success') }}
    </div>
@endif

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <!-- SECCIÓN: DATOS DE USUARIO / CUENTA -->
    <section class="rounded-[28px] border border-[#D8E6EB] bg-white p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
        <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.24em]" style="color: {{ $color }}">Cuenta {{ strtolower($rol) }}</p>
                <h1 class="mt-2 text-2xl font-black text-[#0A2334]">Editar perfil</h1>
                <p class="mt-1 text-sm text-[#5F7785]">Actualiza tus datos personales y de acceso.</p>
            </div>
            <span class="rounded-full bg-[#F1F6F8] px-3 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-[#5F7785]">Campos obligatorios *</span>
        </div>

        <div class="grid gap-5 lg:grid-cols-[180px_1fr]">
            <!-- Foto de perfil -->
            <div class="flex flex-col items-center lg:items-start">
                <div class="relative h-32 w-32">
                    <div class="absolute inset-0 rounded-full bg-white p-1.5 shadow-[0_10px_25px_rgba(15,40,53,0.12)] ring-1 ring-[#D8E6EB]">
                        <div class="flex h-full w-full items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-[#39A900] via-[#228B22] to-[#0E6B54] text-3xl font-black text-white">
                            @if ($usuario->foto_perfil)
                                <img id="foto-preview" src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt="Foto actual" class="h-full w-full rounded-full object-cover">
                            @else
                                <span id="foto-inicial">{{ strtoupper(substr($usuario->nombre_1 ?? 'U', 0, 1)) }}</span>
                                <img id="foto-preview" src="" alt="Vista previa de la foto" class="hidden h-full w-full rounded-full object-cover">
                            @endif
                        </div>
                    </div>
                </div>
                <label for="foto_perfil" class="mt-4 inline-flex cursor-pointer rounded-xl border border-[#C8DCE2] px-4 py-2 text-xs font-bold text-[#0A2334] transition hover:border-[#39A900] hover:text-[#0E6B54]">Cambiar foto PNG</label>
                <input id="foto_perfil" name="foto_perfil" type="file" accept="image/png" class="sr-only">
                <p class="mt-2 text-[11px] text-[#78909C]">Máximo 2 MB.</p>
            </div>

            <!-- Campos Básicos -->
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="nombre_1" class="form-label">Primer nombre *</label>
                    <input id="nombre_1" name="nombre_1" value="{{ old('nombre_1', $usuario->nombre_1) }}" required class="form-input">
                </div>
                <div>
                    <label for="nombre_2" class="form-label">Segundo nombre</label>
                    <input id="nombre_2" name="nombre_2" value="{{ old('nombre_2', $usuario->nombre_2) }}" class="form-input">
                </div>
                <div>
                    <label for="apellido_1" class="form-label">Primer apellido *</label>
                    <input id="apellido_1" name="apellido_1" value="{{ old('apellido_1', $usuario->apellido_1) }}" required class="form-input">
                </div>
                <div>
                    <label for="apellido_2" class="form-label">Segundo apellido</label>
                    <input id="apellido_2" name="apellido_2" value="{{ old('apellido_2', $usuario->apellido_2) }}" class="form-input">
                </div>
                <div>
                    <label for="tipo_identificacion" class="form-label">Tipo de identificación *</label>
                    <select id="tipo_identificacion" name="tipo_identificacion" required class="form-input">
                        @foreach (['CC', 'TI', 'CE', 'PPT'] as $tipo)
                            <option value="{{ $tipo }}" @selected(old('tipo_identificacion', $usuario->tipo_identificacion) === $tipo)>{{ $tipo }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="identificacion" class="form-label">Número de identificación *</label>
                    <input id="identificacion" name="identificacion" value="{{ old('identificacion', $usuario->identificacion) }}" required class="form-input">
                </div>
                <div class="sm:col-span-2">
                    <label for="email" class="form-label">Correo electrónico *</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $usuario->email) }}" required class="form-input">
                </div>
            </div>
        </div>
    </section>

    <!-- SECCIÓN: DATOS ESPECÍFICOS SEGÚN EL ROL -->
    <section class="rounded-[28px] border border-[#D8E6EB] bg-white p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
        <div class="mb-5">
            <h2 class="text-xl font-extrabold text-[#0A2334]">Datos de {{ strtolower($rol) }}</h2>
            <p class="mt-1 text-sm text-[#5F7785]">Estos campos corresponden a la información registrada para tu rol.</p>
        </div>

        @if ($rol === 'Administrador')
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="cargo" class="form-label">Cargo *</label>
                    <input id="cargo" name="cargo" value="{{ old('cargo', $usuario->admin?->cargo) }}" required class="form-input">
                </div>
                <div>
                    <label for="ubicacion_oficina" class="form-label">Ubicación de oficina *</label>
                    <input id="ubicacion_oficina" name="ubicacion_oficina" value="{{ old('ubicacion_oficina', $usuario->admin?->ubicacion_oficina) }}" required class="form-input">
                </div>
                <div class="md:col-span-2">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input id="direccion" name="direccion" value="{{ old('direccion', $usuario->admin?->direccion) }}" class="form-input">
                </div>
            </div>

        @elseif ($rol === 'Aprendiz')
            <div class="grid gap-4 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label for="course_group_id" class="form-label">Ficha *</label>
                    <select id="course_group_id" name="course_group_id" required class="form-input">
                        @foreach ($fichas as $ficha)
                            <option value="{{ $ficha->id }}" @selected((string) old('course_group_id', $usuario->apprentice?->course_group_id) === (string) $ficha->id)>
                                {{ $ficha->codigo }}{{ $ficha->program ? ' · ' . $ficha->program->nombre : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="estado" class="form-label">Estado *</label>
                    <select id="estado" name="estado" required class="form-input">
                        @foreach (['Activo', 'Retirado', 'Certificado'] as $estado)
                            <option value="{{ $estado }}" @selected(old('estado', $usuario->apprentice?->estado) === $estado)>{{ $estado }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="fecha_inicio" class="form-label">Fecha de inicio *</label>
                    <input id="fecha_inicio" name="fecha_inicio" type="date" value="{{ old('fecha_inicio', $usuario->apprentice?->fecha_inicio?->format('Y-m-d')) }}" required class="form-input">
                </div>
                <div>
                    <label for="fecha_fin" class="form-label">Fecha de finalización</label>
                    <input id="fecha_fin" name="fecha_fin" type="date" value="{{ old('fecha_fin', $usuario->apprentice?->fecha_fin?->format('Y-m-d')) }}" class="form-input">
                </div>
            </div>

        @elseif ($rol === 'Instructor')
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="area_id" class="form-label">Área *</label>
                    <select id="area_id" name="area_id" required class="form-input">
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" @selected((string) old('area_id', $usuario->teacher?->area_id) === (string) $area->id)>{{ $area->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tipo_instructor" class="form-label">Tipo de instructor *</label>
                    <select id="tipo_instructor" name="tipo_instructor" required class="form-input">
                        @foreach (['Planta', 'Contratista'] as $tipo)
                            <option value="{{ $tipo }}" @selected(old('tipo_instructor', $usuario->teacher?->tipo_instructor) === $tipo)>{{ $tipo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label for="especialidad" class="form-label">Especialidad *</label>
                    <input id="especialidad" name="especialidad" value="{{ old('especialidad', $usuario->teacher?->especialidad) }}" required class="form-input">
                </div>
                <div>
                    <label for="fecha_inicio" class="form-label">Fecha de inicio *</label>
                    <input id="fecha_inicio" name="fecha_inicio" type="date" value="{{ old('fecha_inicio', $usuario->teacher?->fecha_inicio) }}" required class="form-input">
                </div>
                <div>
                    <label for="fecha_fin" class="form-label">Fecha de finalización</label>
                    <input id="fecha_fin" name="fecha_fin" type="date" value="{{ old('fecha_fin', $usuario->teacher?->fecha_fin) }}" class="form-input">
                </div>
            </div>

        @else
            <!-- ASPIRANTE -->
            <div class="grid gap-4 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label for="eps" class="form-label">EPS *</label>
                    <select id="eps" name="eps" required class="form-input">
                        @foreach (['SURA', 'Sanitas', 'Nueva EPS', 'Salud Total', 'Compensar', 'Coosalud', 'Emssanar'] as $eps)
                            <option value="{{ $eps }}" @selected(old('eps', $usuario->aspirant?->eps) === $eps)>{{ $eps }}</option>
                        @endforeach
                    </select>
                </div>
                @foreach (['certificado_eps' => 'Certificado EPS', 'certificado_bachiller' => 'Certificado de bachiller', 'certificado_icfes' => 'Certificado ICFES'] as $campo => $label)
                    <div>
                        <label for="{{ $campo }}" class="form-label">{{ $label }}</label>
                        <input id="{{ $campo }}" name="{{ $campo }}" type="file" accept=".pdf,.png,.jpg,.jpeg" class="block w-full rounded-xl border border-[#C8DCE2] bg-white px-3 py-2 text-sm text-[#5F7785] file:mr-3 file:rounded-lg file:border-0 file:bg-[#F1F6F8] file:px-3 file:py-2 file:text-xs file:font-bold file:text-[#0A2334]">
                        @if ($usuario->aspirant?->{$campo})
                            <a href="{{ asset('storage/' . $usuario->aspirant->{$campo}) }}" target="_blank" class="mt-2 inline-block text-xs font-bold text-[#C46D63] hover:underline">Ver documento actual</a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- BOTONES -->
    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
        <a href="{{ $backRoute }}" class="inline-flex items-center justify-center rounded-xl border border-[#C8DCE2] px-5 py-3 text-sm font-bold text-[#0A2334] transition hover:border-[#78909C]">Cancelar</a>
        <button type="submit" class="inline-flex items-center justify-center rounded-xl px-5 py-3 text-sm font-extrabold text-[#001E30] shadow-lg transition hover:-translate-y-0.5" style="background-color: {{ $color }}">Guardar cambios</button>
    </div>
</form>

@once
    @push('styles')
        <style>
            .form-label { display: block; margin-bottom: .5rem; color: #0A2334; font-size: .75rem; font-weight: 800; }
            .form-input { width: 100%; border-radius: .75rem; border: 1px solid #C8DCE2; background: #fff; padding: .75rem .875rem; color: #0A2334; outline: none; }
            .form-input:focus { border-color: #39A900; box-shadow: 0 0 0 3px rgba(57,169,0,.12); }
        </style>
    @endpush
    @push('scripts')
        <script>
            document.getElementById('foto_perfil')?.addEventListener('change', function (event) {
                const file = event.target.files?.[0];
                const preview = document.getElementById('foto-preview');
                const initial = document.getElementById('foto-inicial');
                if (!file || !preview) return;
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                initial?.classList.add('hidden');
            });
        </script>
    @endpush
@endonce