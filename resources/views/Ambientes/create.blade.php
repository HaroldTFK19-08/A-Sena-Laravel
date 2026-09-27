@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Nuevo Ambiente')

@section('contenido')
	<div class="space-y-8">
		<section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 shadow-[0_20px_45px_rgba(15,40,53,0.08)] md:p-8">
			<div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(138,253,93,0.18),_transparent_35%)]"></div>
			<div class="relative z-10 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
				<div><p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Gestión institucional</p><h1 class="mt-3 text-3xl font-black text-[#0A2334] md:text-4xl">Registrar ambiente</h1><p class="mt-3 text-sm text-[#3b5d6e]">Agrega un nuevo espacio de formación al sistema.</p></div>
				<a href="{{ route('ambientes.index') }}" class="inline-flex items-center justify-center rounded-xl border border-[#C7DCE2] bg-white/70 px-5 py-3 text-sm font-semibold text-[#0A2334] hover:bg-white">Volver al listado</a>
			</div>
		</section>
		<section class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 shadow-[0_12px_26px_rgba(15,40,53,0.06)] md:p-8">
			<div class="mb-6 border-b border-[#E3ECEF] pb-4"><h2 class="text-xl font-extrabold text-[#0A2334]">Datos del ambiente</h2><p class="mt-1 text-xs text-[#5F7785]">Los campos marcados con * son obligatorios.</p></div>
			@include('Ambientes.partials.form', ['action' => route('ambientes.store'), 'method' => 'POST', 'ambiente' => null])
		</section>
	</div>
@endsection
