<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $this->wantsJson($request) ? null : route('auth.login');
    }

    /**
     * Launch an authentication exception.
     *
     * La clase base ignora el valor devuelto por este método: espera que se
     * lance la excepción. App\Exceptions\Handler se encarga de convertirla en
     * un 401 JSON (peticiones de API) o en una redirección a `auth.login`
     * (peticiones web).
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            'Unauthenticated.',
            $guards,
            $this->redirectTo($request),
        );
    }

    private function wantsJson(Request $request): bool
    {
        return $request->expectsJson()
            || $request->is('v1/*')
            || $request->is('api/*');
    }
}
