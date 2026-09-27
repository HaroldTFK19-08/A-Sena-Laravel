<?php

namespace App\Dominios\Usuarios\Requests;

use App\Support\Concerns\ResolvesApiUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserApiRequest extends FormRequest
{
    use ResolvesApiUser;

    public function authorize(): bool
    {
        $user = $this->resolveApiUser($this);

        if (! $user && $this->apiPracticeMode()) {
            return true;
        }

        return $user?->rol === 'Admin';
    }

    public function rules(): array
    {
        $usuario = $this->route('usuario');
        $actualizando = $usuario !== null;

        return [
            'nombre_1' => ['required', 'string', 'max:20'],
            'nombre_2' => ['nullable', 'string', 'max:20'],
            'apellido_1' => ['required', 'string', 'max:20'],
            'apellido_2' => ['nullable', 'string', 'max:20'],
            'tipo_identificacion' => ['required', Rule::in(['CC', 'TI', 'CE', 'PPT'])],
            'identificacion' => ['required', 'string', 'max:255', Rule::unique('users', 'identificacion')->ignore($usuario)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($usuario)],
            'rol' => ['required', Rule::in(['Admin', 'Instructor', 'Aprendiz', 'Aspirante'])],
            'password' => [$actualizando ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => [$actualizando ? 'nullable' : 'required', 'string', 'min:8'],
            'foto_perfil' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ];
    }
}
