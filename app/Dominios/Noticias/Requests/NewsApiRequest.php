<?php

namespace App\Dominios\Noticias\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->rol === 'Admin';
    }

    public function rules(): array
    {
        return [
            'trainingcenter_id' => ['required', 'integer', 'exists:trainingcenters,id'],
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:2000'],
            'estado' => ['required', Rule::in(['Creado', 'Pendiente', 'Publicado'])],
            'categoria' => ['required', Rule::in(['Tecnologia', 'Educacion', 'Deporte', 'Politica', 'Artistica', 'Diseño'])],
            'publicada' => ['sometimes', 'boolean'],
            'imagen' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ];
    }
}
