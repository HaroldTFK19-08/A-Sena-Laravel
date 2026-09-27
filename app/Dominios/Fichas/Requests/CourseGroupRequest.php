<?php

namespace App\Dominios\Fichas\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'program_id' => ['required', 'integer', 'exists:programs,id'],
            'teacher_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $teacher = \App\Dominios\Usuarios\Models\Teacher::find($value);
                    if (!$teacher || strtolower($teacher->tipo_instructor) !== 'planta') {
                        $fail('El instructor seleccionado debe ser de tipo Planta para ser asignado a una ficha.');
                    }
                },
            ],
            'codigo' => ['required', 'string', 'max:255', Rule::unique('course_groups', 'codigo')->ignore($this->route('ficha'))],
            'capacidad_aprendices' => ['required', 'integer', 'min:1'],
        ];
    }
}