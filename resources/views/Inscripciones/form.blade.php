<div class="space-y-8">
    <section class="relative overflow-hidden rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 md:p-8">
        <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Admisión</p>
        <h1 class="mt-3 text-3xl font-black text-[#0A2334]">{{ $titulo }}</h1>
    </section>

    <form class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-8 space-y-6" method="POST" action="{{ $action }}">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-red-50 text-red-600 border border-red-200 text-sm font-semibold">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col gap-2">
                <label class="text-sm font-bold text-[#4b6473]">Aspirante</label>
                <select name="aspirant_id" required class="w-full px-4 py-3 rounded-2xl border border-[#D8E6EB] bg-white outline-none focus:ring-2 focus:ring-[#8AFD5D]">
                    <option value="">Seleccione</option>
                    @foreach ($aspirantes as $aspirante)
                        <option value="{{ $aspirante->id }}" @selected(old('aspirant_id', $inscripcion?->aspirant_id) == $aspirante->id)>
                            {{ $aspirante->user?->nombre_completo ?? 'Aspirante '.$aspirante->id }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-sm font-bold text-[#4b6473]">Oferta</label>
                <select name="offer_id" required class="w-full px-4 py-3 rounded-2xl border border-[#D8E6EB] bg-white outline-none focus:ring-2 focus:ring-[#8AFD5D]">
                    <option value="">Seleccione</option>
                    @foreach ($ofertas as $oferta)
                        <option value="{{ $oferta->id }}" @selected(old('offer_id', $inscripcion?->offer_id) == $oferta->id)>
                            {{ $oferta->program?->nombre ?? 'Oferta '.$oferta->id }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-sm font-bold text-[#4b6473]">Estado</label>
                <select name="estado" required class="w-full px-4 py-3 rounded-2xl border border-[#D8E6EB] bg-white outline-none focus:ring-2 focus:ring-[#8AFD5D]">
                    @foreach ($estados as $estado)
                        <option value="{{ $estado }}" @selected(old('estado', $inscripcion?->estado) == $estado)>{{ $estado }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-sm font-bold text-[#4b6473]">Fecha de inscripción</label>
                <input type="datetime-local" name="Fecha_inscripcion"
                    value="{{ old('Fecha_inscripcion', optional($inscripcion?->Fecha_inscripcion)->format('Y-m-d\TH:i')) }}"
                    class="w-full px-4 py-3 rounded-2xl border border-[#D8E6EB] bg-white outline-none focus:ring-2 focus:ring-[#8AFD5D]">
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button class="px-8 py-3 rounded-2xl bg-[#0E6B54] text-white font-bold hover:bg-[#0a5a46]" type="submit">Guardar</button>
        </div>
    </form>
</div>
