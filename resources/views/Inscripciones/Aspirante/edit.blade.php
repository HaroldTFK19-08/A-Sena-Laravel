@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Editar inscripción')

@section('contenido')
    <div class="space-y-8">
        <section class="rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 md:p-8">
            <h1 class="text-3xl font-black text-[#0A2334]">Editar inscripción</h1>
            <p class="mt-3 text-sm text-[#3b5d6e]">Solo puedes modificar esta inscripción mientras permanezca en estado Registrado.</p>
        </section>

        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-red-50 text-red-600 border border-red-200 text-sm font-semibold">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('aspirante.inscripciones.update', $inscripcion) }}" enctype="multipart/form-data" class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-8 space-y-6">
            @csrf
            @method('PUT')
            <div class="flex flex-col gap-2">
                <label class="text-sm font-bold text-[#4b6473]">Oferta</label>
                <select name="offer_id" required class="w-full rounded-2xl border border-[#D8E6EB] bg-white px-4 py-3">
                    @foreach ($ofertas as $oferta)
                        <option value="{{ $oferta->id }}" @selected(old('offer_id', $inscripcion->offer_id) == $oferta->id)>
                            {{ $oferta->program?->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <label class="text-sm font-bold text-[#4b6473]">Certificado EPS
                    <input type="file" name="certificado_eps" class="mt-2 w-full rounded-2xl border border-[#D8E6EB] bg-white p-3 text-sm">
                    @if ($inscripcion->aspirant?->certificado_eps)
                        <a href="{{ asset('storage/' . $inscripcion->aspirant->certificado_eps) }}" target="_blank" class="mt-2 inline-block text-xs font-bold text-[#0E6B54]">Documento actual</a>
                    @endif
                </label>
                <label class="text-sm font-bold text-[#4b6473]">Certificado bachiller
                    <input type="file" name="certificado_bachiller" class="mt-2 w-full rounded-2xl border border-[#D8E6EB] bg-white p-3 text-sm">
                    @if ($inscripcion->aspirant?->certificado_bachiller)
                        <a href="{{ asset('storage/' . $inscripcion->aspirant->certificado_bachiller) }}" target="_blank" class="mt-2 inline-block text-xs font-bold text-[#0E6B54]">Documento actual</a>
                    @endif
                </label>
                <label class="text-sm font-bold text-[#4b6473]">Certificado ICFES
                    <input type="file" name="certificado_icfes" class="mt-2 w-full rounded-2xl border border-[#D8E6EB] bg-white p-3 text-sm">
                    @if ($inscripcion->aspirant?->certificado_icfes)
                        <a href="{{ asset('storage/' . $inscripcion->aspirant->certificado_icfes) }}" target="_blank" class="mt-2 inline-block text-xs font-bold text-[#0E6B54]">Documento actual</a>
                    @endif
                </label>
            </div>
            <button class="rounded-2xl bg-[#0E6B54] px-8 py-3 font-bold text-white" type="submit">Guardar cambios</button>
        </form>
    </div>
@endsection
