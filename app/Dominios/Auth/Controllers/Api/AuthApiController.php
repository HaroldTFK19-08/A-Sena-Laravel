<?php

namespace App\Dominios\Auth\Controllers\Api;

use App\Dominios\Auth\Requests\LoginRequest;
use App\Dominios\Auth\Requests\RegisterRequest;
use App\Dominios\Usuarios\Models\User;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthApiController extends ApiController
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $user = User::where('email', $credentials['email'])->first();
        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Las credenciales no son correctas.',
            ]);
        }
        $token = $user->createToken($request->input('device_name', 'api-token'))->plainTextToken;

        return $this->success([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Sesión iniciada correctamente.');
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $roles = [
            'aprendiz' => 'Aprendiz',
            'instructor' => 'Instructor',
            'aspirante' => 'Aspirante',
        ];
        $data['rol'] = $roles[strtolower((string) $data['rol'])] ?? $data['rol'];
        $data['password'] = Hash::make($data['password']);
        if ($request->hasFile('foto_perfil')) {
            $data['foto_perfil'] = $request->file('foto_perfil')->store('photos', 'public');
        }
        $user = User::create($data);
        $token = $user->createToken($request->input('device_name', 'api-token'))->plainTextToken;

        return $this->created([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Usuario registrado correctamente.');
    }

    public function me(Request $request): JsonResponse
    {
        $user = $this->currentUser();

        if (! $user) {
            return $this->success(null, 'No hay un usuario autenticado en la solicitud.');
        }

        $user->load(['admin', 'teacher', 'apprentice', 'aspirant']);

        return $this->success($user, 'Usuario autenticado.');
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $this->currentUser();
        $plainToken = $request->bearerToken();
        $token = $user?->currentAccessToken();
        if ($plainToken) {
            PersonalAccessToken::findToken($plainToken)?->delete();
        } elseif ($token && method_exists($token, 'delete')) {
            $token->delete();
        }
        Auth::guard('web')->logout();
        Auth::forgetGuards();

        return $this->success(null, 'Sesión finalizada correctamente.');
    }
}
