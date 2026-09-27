@php
    $pasos = ['Registrado', 'En proceso', 'Seleccionado'];
    $estadoActual = $estado ?? 'Registrado';
    $esRechazado = $estadoActual === 'Rechazado';
    $esCancelado = $estadoActual === 'Cancelada';
    $indiceActual = array_search($estadoActual, $pasos, true);
    if ($indiceActual === false) {
        $indiceActual = $esRechazado ? 2 : 0;
    }
@endphp

@if ($esCancelado)
    <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4">
        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-200 text-slate-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </span>
        <div>
            <p class="text-sm font-bold text-slate-700">Inscripción cancelada</p>
            <p class="text-xs text-slate-500">Esta inscripción ya no continúa en el proceso de admisión.</p>
        </div>
    </div>
@else
    <div class="flex items-center">
        @foreach ($pasos as $indice => $paso)
            @php
                $completado = $indice < $indiceActual || ($indice === $indiceActual && ! $esRechazado);
                $esUltimoYRechazado = $indice === 2 && $esRechazado;
            @endphp
            <div class="flex flex-1 flex-col items-center text-center">
                <span @class([
                    'flex h-9 w-9 items-center justify-center rounded-full text-xs font-black shrink-0',
                    'bg-[#0E6B54] text-white' => $completado && ! $esUltimoYRechazado,
                    'bg-red-500 text-white' => $esUltimoYRechazado,
                    'bg-[#EAF1F3] text-[#5F7785]' => ! $completado && ! $esUltimoYRechazado,
                ])>
                    @if ($esUltimoYRechazado)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    @elseif ($completado)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    @else
                        {{ $indice + 1 }}
                    @endif
                </span>
                <p class="mt-2 text-[11px] font-bold uppercase tracking-[0.08em] {{ $completado || $esUltimoYRechazado ? 'text-[#0A2334]' : 'text-[#8FA3AC]' }}">
                    {{ $esUltimoYRechazado ? 'Rechazado' : $paso }}
                </p>
            </div>
            @if (! $loop->last)
                <div @class([
                    'h-0.5 flex-1 -mt-5',
                    'bg-[#0E6B54]' => $indice < $indiceActual,
                    'bg-[#EAF1F3]' => $indice >= $indiceActual,
                ])></div>
            @endif
        @endforeach
    </div>
@endif
