@props([
    'status',
])

@php
    $statusClasses = match ($status) {
        'Activo', 'Aprobado', 'Seleccionado' => 'bg-emerald-100 text-emerald-700 ring-emerald-600/15',
        'Inactivo', 'Pendiente', 'En proceso', 'Registrado' => 'bg-amber-100 text-amber-800 ring-amber-600/15',
        'Reprobado', 'Rechazado', 'Cancelada' => 'bg-red-100 text-red-700 ring-red-600/15',
        default => 'bg-slate-100 text-slate-700 ring-slate-500/15',
    };
@endphp

<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold ring-1 ring-inset {{ $statusClasses }}">
    {{ $status }}
</span>
