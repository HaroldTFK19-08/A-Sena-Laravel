<?php

namespace App\Dominios\Resultados\Requests;

use App\Dominios\Resultados\Models\Grade;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GradeApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()?->rol, ['Admin', 'Instructor'], true);
    }

    public function rules(): array
    {
        return [
            'result_id' => ['required', 'integer', 'exists:results,id'],
            'apprentice_id' => ['required', 'integer', 'exists:apprentices,id'],
            'teacher_id' => ['nullable', 'integer', 'exists:teachers,id'],
            'estado_resultado' => ['required', Rule::in(Grade::ESTADOS)],
            'comentarios' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
