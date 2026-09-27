@extends('Layouts.Usuarios.AppAdmin')

@section('titulo', 'Registrar calificaciones')

@section('contenido')
    <div class="space-y-8">
        <section class="rounded-[30px] border border-[#D6E6EA] bg-gradient-to-r from-[#DFF2EE] via-[#EAF6F4] to-[#E4EEF6] p-6 md:p-8">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#1B5E6A]">Ficha {{ $ficha->codigo }}</p>
            <h1 class="mt-3 text-3xl font-black text-[#0A2334]">Calificar {{ $competencia->nombre }}</h1>
            <p class="mt-3 text-sm text-[#3B5D6E]">Registra o actualiza el estado de cada resultado para los aprendices de esta ficha.</p>
            <a href="{{ route('instructor.resultados.ficha', $ficha) }}" class="mt-4 inline-flex text-sm font-semibold text-[#0E6B54]">Volver a la ficha</a>
        </section>

        @if ($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-600">{{ $errors->first() }}</div>
        @endif

        @if ($competencia->results->isEmpty() || $ficha->apprentices->isEmpty())
            <div class="rounded-2xl border border-dashed border-[#D8E6EB] bg-white p-10 text-center text-sm text-[#5F7785]">
                No hay aprendices o resultados configurados para calificar.
            </div>
        @else
            <div class="flex flex-col gap-3 rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm font-semibold text-[#234657]">Acción rápida: aplica el mismo estado a todos los aprendices y resultados de esta competencia.</p>
                <div class="flex items-center gap-2">
                    <select id="estado-masivo" class="h-11 rounded-xl border border-[#D8E6EB] bg-white px-3 text-sm">
                        @foreach (['Pendiente', 'Aprobado', 'Reprobado'] as $estado)
                            <option value="{{ $estado }}">{{ $estado }}</option>
                        @endforeach
                    </select>
                    <button type="button" id="aplicar-masivo" class="h-11 rounded-xl border border-[#D8E6EB] bg-white px-4 text-sm font-bold text-[#0A2334] hover:border-[#39A900]">Aplicar a todos</button>
                </div>
            </div>

            <form method="POST" action="{{ route('instructor.resultados.guardar', [$ficha, $competencia]) }}" class="rounded-[30px] border border-[#D8E6EB] bg-[#F7FBFC] p-6">
                @csrf
                @method('PUT')
                @php $indice = 0; @endphp
                <div class="space-y-8">
                    @foreach ($ficha->apprentices as $aprendiz)
                        <div class="rounded-2xl border border-[#D8E6EB] bg-white p-5">
                            <h2 class="text-lg font-extrabold text-[#0A2334]">{{ $aprendiz->user?->nombre_completo }}</h2>
                            <p class="text-xs text-[#5F7785]">{{ $aprendiz->user?->identificacion }}</p>
                            <div class="mt-4 overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead class="text-xs uppercase text-[#4b6473]">
                                        <tr>
                                            <th class="py-3 pr-4">Resultado</th>
                                            <th class="py-3 pr-4">Estado</th>
                                            <th class="py-3">Comentarios</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($competencia->results as $resultado)
                                            @php
                                                $actual = $calificaciones->get($aprendiz->id.'-'.$resultado->id);
                                            @endphp
                                            <tr class="border-t border-[#D8E6EB]/60">
                                                <td class="py-3 pr-4 text-sm font-semibold">{{ $resultado->nombre }}</td>
                                                <td class="py-3 pr-4">
                                                    <input type="hidden" name="calificaciones[{{ $indice }}][apprentice_id]" value="{{ $aprendiz->id }}">
                                                    <input type="hidden" name="calificaciones[{{ $indice }}][result_id]" value="{{ $resultado->id }}">
                                                    <select name="calificaciones[{{ $indice }}][estado_resultado]" class="estado-calificacion rounded-xl border border-[#D8E6EB] px-3 py-2 text-sm">
                                                        @foreach (['Pendiente', 'Aprobado', 'Reprobado'] as $estado)
                                                            <option value="{{ $estado }}" @selected(old("calificaciones.$indice.estado_resultado", $actual?->estado_resultado ?? 'Pendiente') === $estado)>{{ $estado }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="py-3">
                                                    <input name="calificaciones[{{ $indice }}][comentarios]" value="{{ old("calificaciones.$indice.comentarios", $actual?->comentarios) }}" class="w-full rounded-xl border border-[#D8E6EB] px-3 py-2 text-sm">
                                                </td>
                                            </tr>
                                            @php $indice++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 flex justify-end">
                    <button class="rounded-2xl bg-[#0E6B54] px-8 py-3 font-bold text-white" type="submit">Guardar calificaciones</button>
                </div>
            </form>
        @endif
    </div>

    @push('scripts')
        <script>
            document.getElementById('aplicar-masivo')?.addEventListener('click', function () {
                const estado = document.getElementById('estado-masivo').value;
                document.querySelectorAll('.estado-calificacion').forEach(function (select) {
                    select.value = estado;
                });
            });
        </script>
    @endpush
@endsection
