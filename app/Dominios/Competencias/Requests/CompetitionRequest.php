<?php

namespace App\Dominios\Competencias\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompetitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'teacher_id' => ['nullable', 'integer', 'exists:teachers,id'],
            'codigo' => ['nullable', 'string', 'max:255', Rule::unique('competitions', 'codigo')->ignore($this->route('competencia'))],
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],
        ];
    }
}