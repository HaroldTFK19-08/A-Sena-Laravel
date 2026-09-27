@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Ambientes de Formación')

@section('contenido')
	<div class="space-y-8">
		<section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.08)] md:p-8">
			<div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>
			<div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
				<div>
					<p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Gestión institucional</p>
					<h1 class="mt-3 text-3xl font-black leading-tight text-[#0A2334] md:text-4xl">Ambientes de Formación</h1>
					<p class="mt-3 max-w-2xl text-sm leading-relaxed text-[#3b5d6e] md:text-base">Administra los espacios de formación, su capacidad y el tipo de ambiente asignado.</p>
				</div>
				<a href="{{ route('ambientes.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#8AFD5D] px-5 py-3 text-sm font-extrabold text-[#001E30] shadow-lg shadow-[#8AFD5D]/20 transition-transform hover:-translate-y-0.5">
					<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/></svg>
					Nuevo ambiente
				</a>
			</div>
		</section>

		@if (session('success'))
			<div class="rounded-2xl border border-[#BFE6B1] bg-[#EAFBF0] p-4 text-sm font-semibold text-[#0E6B54]">{{ session('success') }}</div>
		@endif

		<section class="grid grid-cols-1 gap-5 md:grid-cols-3">
			<div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
				<p class="text-sm text-[#4b6473]">Total ambientes</p>
				<p class="mt-4 text-3xl font-black text-[#0A2334]">{{ $ambientes->count() }}</p>
				<p class="mt-2 text-xs text-[#5F7785]">Espacios registrados en el sistema</p>
			</div>
			<div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
				<p class="text-sm text-[#4b6473]">Capacidad total</p>
				<p class="mt-4 text-3xl font-black text-[#0A2334]">{{ $ambientes->sum('capacidad') }}</p>
				<p class="mt-2 text-xs text-[#5F7785]">Personas de capacidad instalada</p>
			</div>
			<div class="rounded-[26px] border border-[#D8E6EB] bg-[#F7FBFC] p-5 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
				<p class="text-sm text-[#4b6473]">Tipos registrados</p>
				<p class="mt-4 text-3xl font-black text-[#0A2334]">{{ $ambientes->pluck('tipo_ambiente')->unique()->count() }}</p>
				<p class="mt-2 text-xs text-[#5F7785]">Categorías de ambientes activas</p>
			</div>
		</section>

		<section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)]">
			<div class="mb-5"><p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Listado</p><h2 class="mt-2 text-xl font-extrabold text-[#0A2334]">Todos los ambientes</h2></div>
			@if ($ambientes->isEmpty())
				<div class="rounded-2xl border border-dashed border-[#D8E6EB] bg-white p-10 text-center"><p class="text-sm font-semibold text-[#5F7785]">Aún no hay ambientes registrados.</p><a href="{{ route('ambientes.create') }}" class="mt-4 inline-flex rounded-xl bg-[#8AFD5D] px-5 py-2.5 text-sm font-extrabold text-[#001E30]">Crear el primer ambiente</a></div>
			@else
				<div class="overflow-x-auto rounded-2xl border border-[#D8E6EB]"><table class="min-w-full divide-y divide-[#D8E6EB]"><thead class="bg-white"><tr><th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Ambiente</th><th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Centro</th><th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Tipo</th><th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Capacidad</th><th class="px-5 py-3 text-right text-[10px] font-bold uppercase tracking-[0.2em] text-[#5F7785]">Acciones</th></tr></thead><tbody class="divide-y divide-[#EAF1F3] bg-[#F7FBFC]">
					@foreach ($ambientes as $ambiente)
						<tr class="transition-colors hover:bg-white"><td class="px-5 py-4"><div class="flex items-center gap-3"><span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#D8F7CB] text-sm font-black text-[#0E6B54]">{{ strtoupper(substr($ambiente->nombre, 0, 1)) }}</span><span class="text-sm font-bold text-[#0A2334]">{{ $ambiente->nombre }}</span></div></td><td class="px-5 py-4 text-sm text-[#456073]">{{ $ambiente->trainingcenter?->nombre ?? 'Sin centro' }}</td><td class="px-5 py-4"><span class="rounded-full bg-[#EAF6F4] px-3 py-1 text-xs font-bold text-[#0E6B54]">{{ $ambiente->tipo_ambiente }}</span></td><td class="px-5 py-4 text-sm font-bold text-[#0A2334]">{{ $ambiente->capacidad }} personas</td><td class="px-5 py-4"><div class="flex justify-end gap-2"><a href="{{ route('ambientes.show', $ambiente->id) }}" title="Ver detalle" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#D8E6EB] bg-white text-[#0E6B54] hover:bg-[#EAFBF0]"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178zM15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></a><a href="{{ route('ambientes.edit', $ambiente->id) }}" title="Editar" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#D8E6EB] bg-white text-[#1B5E6A] hover:bg-[#F0F7FB]"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg></a><form action="{{ route('ambientes.destroy', $ambiente->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este ambiente?');">@csrf @method('DELETE')<button type="submit" title="Eliminar" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-rose-200 bg-white text-rose-500 hover:bg-rose-50"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 7h12m-9 0v-.75A1.25 1.25 0 0110.25 5h3.5A1.25 1.25 0 0115 6.25V7m-7.5 0l.75 12h7.5l.75-12M10 10v6m4-6v6"/></svg></button></form></div></td></tr>
					@endforeach
				</tbody></table></div>
			@endif
		</section>
	</div>
@endsection
