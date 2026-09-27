@php
    $clases = match ($estado ?? '') {
        'Registrado' => 'bg-[#EAFBF0] text-[#0E6B54] border-[#BCE6B0]',
        'En proceso' => 'bg-amber-50 text-amber-700 border-amber-200',
        'Seleccionado' => 'bg-sky-50 text-sky-700 border-sky-200',
        'Rechazado' => 'bg-red-50 text-red-600 border-red-200',
        'Cancelada' => 'bg-slate-100 text-slate-600 border-slate-200',
        'Aprobado' => 'bg-[#EAFBF0] text-[#0E6B54] border-[#BCE6B0]',
        'Reprobado' => 'bg-red-50 text-red-600 border-red-200',
        'Pendiente' => 'bg-amber-50 text-amber-700 border-amber-200',
        default => 'bg-slate-100 text-slate-600 border-slate-200',
    };
@endphp
<span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-bold {{ $clases }}">
    {{ $estado }}
</span>
