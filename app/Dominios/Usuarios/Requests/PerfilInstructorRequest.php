<?php

namespace App\Dominios\Usuarios\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PerfilInstructorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_1' => ['required', 'string', 'max:20'],
            'nombre_2' => ['nullable', 'string', 'max:20'],
            'apellido_1' => ['required', 'string', 'max:20'],
            'apellido_2' => ['nullable', 'string', 'max:20'],
            'foto_perfil' => ['nullable', 'image', 'mimes:png', 'max:2048'],
            'tipo_identificacion' => ['required', Rule::in(['CC', 'TI', 'CE', 'PPT'])],
            'identificacion' => ['required', 'string', Rule::unique('users', 'identificacion')->ignore($this->user()?->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user()?->id)],
            'area_id' => ['required', 'exists:areas,id'],
            'especialidad' => ['required', 'string', 'max:150'],
            'tipo_instructor' => ['required', Rule::in(['Planta', 'Contratista'])],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_1.required' => 'El primer nombre es obligatorio.',
            'nombre_1.max' => 'El primer nombre no puede superar los 20 caracteres.',
            'nombre_2.max' => 'El segundo nombre no puede superar los 20 caracteres.',
            'apellido_1.required' => 'El primer apellido es obligatorio.',
            'apellido_1.max' => 'El primer apellido no puede superar los 20 caracteres.',
            'apellido_2.max' => 'El segundo apellido no puede superar los 20 caracteres.',
            'foto_perfil.image' => 'La foto de perfil debe ser una imagen válida.',
            'foto_perfil.mimes' => 'La foto de perfil debe estar en formato PNG.',
            'foto_perfil.max' => 'La foto de perfil no puede superar los 2 MB.',
            'tipo_identificacion.required' => 'El tipo de identificación es obligatorio.',
            'tipo_identificacion.in' => 'El tipo de identificación seleccionado no es válido.',
            'identificacion.required' => 'El número de identificación es obligatorio.',
            'identificacion.unique' => 'El número de identificación ya está registrado.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'area_id.required' => 'Debes seleccionar un área.',
            'area_id.exists' => 'El área seleccionada no existe.',
            'especialidad.required' => 'La especialidad es obligatoria.',
            'especialidad.max' => 'La especialidad no puede superar los 150 caracteres.',
            'tipo_instructor.required' => 'El tipo de instructor es obligatorio.',
            'tipo_instructor.in' => 'El tipo de instructor seleccionado no es válido.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio no tiene un formato válido.',
            'fecha_fin.date' => 'La fecha de finalización no tiene un formato válido.',
            'fecha_fin.after_or_equal' => 'La fecha de finalización debe ser posterior o igual a la fecha de inicio.',
        ];
    }
}