<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Convert an authentication exception into a response.
     *
     * Las peticiones de la API (/v1/*) siempre reciben JSON, aunque el cliente
     * no envíe la cabecera Accept: application/json. El resto responde con una
     * redirección a la pantalla de login.
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($this->isApiRequest($request)) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 401, [
                'WWW-Authenticate' => 'Bearer',
            ]);
        }

        return redirect()->guest($exception->redirectTo($request) ?? route('auth.login'));
    }

    private function isApiRequest(Request $request): bool
    {
        return $request->expectsJson()
            || $request->is('v1/*')
            || $request->is('api/*');
    }
}
