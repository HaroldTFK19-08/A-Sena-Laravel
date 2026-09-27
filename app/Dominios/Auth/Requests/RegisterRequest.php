<?php

namespace App\Dominios\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_1' => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z]+$/'],
            'nombre_2' => ['nullable', 'string', 'max:20', 'regex:/^[a-zA-Z]+$/'],
            'apellido_1' => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z]+$/'],
            'apellido_2' => ['nullable', 'string', 'max:20', 'regex:/^[a-zA-Z]+$/'],
            'foto_perfil' => [
                'nullable',
                'image',
                'mimes:png',
                'max:2048',
            ],
            'tipo_identificacion' => [
                'required',
                'in:CC,TI,CE,PPT',
            ],
            'identificacion' => [
                'required',
                'string',
                'unique:users,identificacion',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'max:8',
                'confirmed',
            ],
            'rol' => [
                'required',
                'in:aprendiz,instructor,aspirante',
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe contener texto.',
            'max' => 'El campo :attribute no puede superar :max caracteres.',
            'regex' => 'El campo :attribute solo puede contener letras.',
            'image' => 'La foto de perfil debe ser una imagen válida.',
            'mimes' => 'La foto de perfil debe estar en formato PNG.',
            'email' => 'El correo electrónico no tiene un formato válido.',
            'unique' => 'El :attribute ya está registrado.',
            'confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
    public function attributes(): array
    {
        return [
            'nombre_1' => 'primer nombre',
            'nombre_2' => 'segundo nombre',
            'apellido_1' => 'primer apellido',
            'apellido_2' => 'segundo apellido',
            'foto_perfil' => 'foto de perfil',
            'tipo_identificacion' => 'tipo de identificación',
            'identificacion' => 'número de identificación',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'rol' => 'rol',
        ];
    }
}

