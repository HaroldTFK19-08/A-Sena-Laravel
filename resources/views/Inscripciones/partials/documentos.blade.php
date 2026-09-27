@php
    $documentos = [
        'certificado_eps' => 'Certificado EPS',
        'certificado_bachiller' => 'Certificado de bachiller',
        'certificado_icfes' => 'Certificado ICFES',
    ];
    $aspirante = $aspirante ?? $inscripcion?->aspirant;
@endphp
<div class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6">
    <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#5F7785]">Documentos</p>
    <div class="mt-4 space-y-3 text-sm">
        @foreach ($documentos as $campo => $etiqueta)
            @if ($aspirante?->{$campo})
                <a href="{{ asset('storage/' . $aspirante->{$campo}) }}" target="_blank" class="flex items-center justify-between rounded-2xl border border-[#D8E6EB] bg-white px-4 py-3 font-semibold text-[#0E6B54] hover:bg-[#F4FFF1]">
                    <span>{{ $etiqueta }}</span>
                    <span class="text-xs">Ver archivo</span>
                </a>
            @else
                <div class="rounded-2xl border border-dashed border-[#D8E6EB] bg-white px-4 py-3 text-[#5F7785]">
                    {{ $etiqueta }}: sin cargar
                </div>
            @endif
        @endforeach
    </div>
</div>
