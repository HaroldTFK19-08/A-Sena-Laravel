@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Gestión de Usuarios')

@section('contenido')
    <div class="space-y-6">

        <!-- HERO -->
        <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#EAF5F4] via-[#F1F8F7] to-[#E9F0F7] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.08)] md:p-8">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>
            <div class="relative z-10">
                <span class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Administración</span>
                <h1 class="mt-2 text-3xl font-black text-[#0A2334] md:text-4xl">Usuarios del Sistema</h1>
                <p class="mt-2 max-w-2xl text-sm leading-relaxed text-[#3B5D6E] md:text-base">
                    Consulta y administra todas las cuentas registradas en la plataforma ADMIN SENA.
                </p>
            </div>
        </section>

        <!-- MENSAJE ÉXITO -->
        @if (session('success'))
            <div class="flex items-center gap-3 rounded-2xl border border-[#BCE6B0] bg-[#D8F7CB] p-4 text-sm font-semibold text-[#0E6B54]">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- CONTENIDO PRINCIPAL -->
        <section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">

            <!-- ENCABEZADO -->
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Control de acceso</span>
                    <h2 class="mt-1 text-xl font-extrabold text-[#0A2334]">Usuarios registrados</h2>
                </div>
                <span class="w-fit rounded-full border border-[#D8E6EB] bg-white px-3.5 py-1 text-sm font-semibold text-[#78909C]">
                    {{ $usuarios->total() }} {{ $usuarios->total() === 1 ? 'usuario' : 'usuarios' }}
                </span>
            </div>

            <!-- BUSCADOR -->
            <form action="{{ route('admin.filtrar') }}" method="GET" class="mb-6 rounded-[24px] border border-[#D8E6EB] bg-white p-5 shadow-[0_8px_24px_rgba(15,40,53,0.05)] md:p-6">
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-[1fr_220px_auto] lg:items-end">
                    
                    <!-- Campo Buscar -->
                    <div>
                        <label for="buscar" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-[#5F7785]">Buscar usuario</label>
                        <div class="relative">
                            <input id="buscar" type="search" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre, correo o identificación..."
                                   class="h-12 w-full rounded-2xl border border-[#D8E6EB] bg-[#F9FBFC] px-4 text-sm text-[#0A2334] outline-none transition focus:border-[#8AFD5D] focus:bg-white focus:ring-4 focus:ring-[#8AFD5D]/10">
                        </div>
                    </div>

                    <!-- Filtro Rol (Solo Instructor, Aprendiz, Aspirante) -->
                    <div>
                        <label for="rol" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-[#5F7785]">Rol</label>
                        <select id="rol" name="rol" class="h-12 w-full rounded-2xl border border-[#D8E6EB] bg-[#F9FBFC] px-4 text-sm text-[#3B5D6E] outline-none transition focus:border-[#8AFD5D] focus:bg-white focus:ring-4 focus:ring-[#8AFD5D]/10">
                            <option value="">Todos los roles</option>
                            @foreach(['Instructor' => 'Instructor', 'Aprendiz' => 'Aprendiz', 'Aspirante' => 'Aspirante'] as $val => $label)
                                <option value="{{ $val }}" @selected(request('rol') === $val)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="flex gap-2">
                        <button type="submit" class="inline-flex h-12 flex-1 items-center justify-center gap-2 rounded-2xl bg-[#0E6B54] px-6 text-sm font-bold text-white transition hover:bg-[#0A5A46] lg:flex-none">
                            Buscar
                        </button>
                        @if (request('buscar') || request('rol'))
                            <a href="{{ route('admin.filtrar') }}" class="inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-[#D8E6EB] bg-white text-[#78909C] transition hover:bg-[#F7FBFC]" title="Limpiar filtros">
                                ✕
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Chips Filtros Activos -->
                @if (request('buscar') || request('rol'))
                    <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-[#EAF1F3] pt-4 text-xs font-semibold text-[#45616F]">
                        <span class="text-[#78909C]">Filtros:</span>
                        @if (request('buscar')) <span class="rounded-full bg-[#F1F7F8] px-3 py-1">"{{ request('buscar') }}"</span> @endif
                        @if (request('rol')) <span class="rounded-full bg-[#EAFBF0] px-3 py-1 text-[#0E6B54]">{{ request('rol') }}</span> @endif
                    </div>
                @endif
            </form>

            <!-- TABLA / ESTADO VACÍO -->
            @if ($usuarios->isEmpty())
                <div class="rounded-2xl border border-dashed border-[#D8E6EB] bg-white p-10 text-center">
                    <p class="text-sm font-semibold text-[#5F7785]">No se encontraron usuarios.</p>
                </div>
            @else
                <div class="overflow-hidden rounded-2xl border border-[#D8E6EB] bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="border-b border-[#D8E6EB] bg-[#F1F7F8] text-xs font-bold uppercase text-[#5F7785]">
                                <tr>
                                    <th class="px-5 py-4">Usuario</th>
                                    <th class="px-5 py-4">Correo Electrónico</th>
                                    <th class="px-5 py-4">Rol</th>
                                    <th class="px-5 py-4">Registro</th>
                                    <th class="px-5 py-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#EAF1F3]">
                                @foreach ($usuarios as $usuario)
                                    @php
                                        $nombreCompleto = trim("{$usuario->nombre_1} {$usuario->nombre_2} {$usuario->apellido_1} {$usuario->apellido_2}");
                                        $rolesColor = [
                                            'Instructor' => 'bg-blue-50 text-blue-600',
                                            'Aprendiz' => 'bg-emerald-50 text-emerald-700',
                                            'Aspirante' => 'bg-amber-50 text-amber-600',
                                        ];
                                    @endphp
                                    <tr class="transition hover:bg-[#F8FBFC]">
                                        <!-- Usuario -->
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full border border-[#BCE6B0] bg-[#EAF6F4] font-black text-[#0E6B54]">
                                                    @if ($usuario->foto_perfil)
                                                        <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt="{{ $nombreCompleto }}" class="h-full w-full object-cover">
                                                    @else
                                                        {{ strtoupper(substr($usuario->nombre_1 ?? 'U', 0, 1)) }}
                                                    @endif
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="truncate font-extrabold text-[#0A2334]">{{ $nombreCompleto ?: 'Sin nombre' }}</p>
                                                    <p class="text-xs text-[#8AA0AA]">ID #{{ $usuario->id }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Correo -->
                                        <td class="px-5 py-4 text-[#5F7785]">{{ $usuario->email }}</td>
                                        <!-- Rol -->
                                        <td class="px-5 py-4">
                                            <span class="inline-block rounded-full px-3 py-1 text-xs font-bold {{ $rolesColor[$usuario->rol] ?? 'bg-gray-100 text-gray-600' }}">
                                                {{ $usuario->rol ?? 'Sin rol' }}
                                            </span>
                                        </td>
                                        <!-- Fecha -->
                                        <td class="px-5 py-4 text-[#5F7785]">{{ $usuario->created_at?->format('d/m/Y') ?? '—' }}</td>
                                        <!-- Acciones -->
                                        <td class="px-5 py-4 text-right">
                                            <a href="#" class="inline-flex items-center gap-1.5 rounded-xl border border-[#D8E6EB] bg-white px-3.5 py-1.5 text-xs font-bold text-[#4B6473] transition hover:border-[#BCE6B0] hover:bg-[#F1F8F7] hover:text-[#0E6B54]">
                                                Ver perfil
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PAGINACIÓN -->
                <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-[#78909C]">
                        Mostrando <span class="font-bold text-[#3B5D6E]">{{ $usuarios->firstItem() }}</span> - <span class="font-bold text-[#3B5D6E]">{{ $usuarios->lastItem() }}</span> de <span class="font-bold text-[#3B5D6E]">{{ $usuarios->total() }}</span>
                    </p>
                    <div>{{ $usuarios->onEachSide(1)->links() }}</div>
                </div>
            @endif
        </section>
    </div>
@endsection