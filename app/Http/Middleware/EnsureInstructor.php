<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureInstructor
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($request->user()?->rol === 'Instructor', 403);
        return $next($request);
    }
}
