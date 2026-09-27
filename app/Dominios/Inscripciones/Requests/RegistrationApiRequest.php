<?php

namespace App\Dominios\Inscripciones\Requests;

use App\Dominios\Inscripciones\Models\Registration;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()?->rol, ['Admin', 'Aspirante'], true);
    }

    public function rules(): array
    {
        $admin = $this->user()?->rol === 'Admin';

        return [
            'aspirant_id' => [$admin ? 'required' : 'nullable', 'integer', 'exists:aspirants,id'],
            'offer_id' => ['required', 'integer', 'exists:offers,id'],
            'estado' => [$admin ? 'required' : 'nullable', Rule::in(Registration::ESTADOS)],
            'Fecha_inscripcion' => ['nullable', 'date'],
        ];
    }
}
