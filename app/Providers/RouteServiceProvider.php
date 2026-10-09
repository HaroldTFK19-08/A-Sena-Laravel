<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    /**
     * Ruta de inicio de cada portal según el rol del usuario.
     *
     * Se comparte entre el login (LoginController) y el middleware `guest`
     * (RedirectIfAuthenticated) para que ambos redirijan al mismo sitio.
     */
    public const ROLE_HOME = [
        'Admin' => 'admin.home',
        'Instructor' => 'instructor.home',
        'Aprendiz' => 'aprendiz.home',
        'Aspirante' => 'aspirante.home',
    ];

    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(1000)
                ->by($request->user()?->id ?: $request->ip());
        });
        $this->routes(function () {
            // Rutas generales API
            Route::middleware('api')
                ->prefix('v1')
                ->group(base_path('routes/api.php'));
            // Rutas generales Web
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
            // =====================
            // AUTH
            // =====================
            Route::middleware('web')
                ->group(base_path('app/Dominios/Auth/Routes/web.php'));
            Route::middleware('api')
                ->prefix('v1')
                ->group(base_path('app/Dominios/Auth/Routes/api.php'));
            // =====================
            // USUARIOS
            // =====================
            Route::middleware('web')
                ->group(base_path('app/Dominios/Usuarios/Routes/web.php'));
            Route::middleware('api')
                ->prefix('v1')
                ->group(base_path('app/Dominios/Usuarios/Routes/api.php'));
            // =========================
            // CENTROS
            // =========================
            Route::middleware('web')
                ->group(base_path('app/Dominios/Centros/Routes/web.php'));
            Route::middleware('api')
                ->prefix('v1')
                ->group(base_path('app/Dominios/Centros/Routes/api.php'));
            // ==========================
            // AMBIENTES
            // ==========================
            Route::middleware('web')
                ->group(base_path('app/Dominios/Ambientes/Routes/web.php'));
            Route::middleware('api')
                ->prefix('v1')
                ->group(base_path('app/Dominios/Ambientes/Routes/api.php'));
            // =========================
            // OFERTAS
            // =========================
            Route::middleware('web')
                ->group(base_path('app/Dominios/Ofertas/Routes/web.php'));
            Route::middleware('api')
                ->prefix('v1')
                ->group(base_path('app/Dominios/Ofertas/Routes/api.php'));
            // =========================
            // NOTICIAS
            // =========================
            Route::middleware('web')
                ->group(base_path('app/Dominios/Noticias/Routes/web.php'));
            Route::middleware('api')
                ->prefix('v1')
                ->group(base_path('app/Dominios/Noticias/Routes/api.php'));
            // =========================
            // COMPETENCIAS
            // =========================
            Route::middleware('web')
                ->group(base_path('app/Dominios/Competencias/Routes/web.php'));
            Route::middleware('api')
                ->prefix('v1')
                ->group(base_path('app/Dominios/Competencias/Routes/api.php'));
            // =========================
            // AREAS
            // =========================
            Route::middleware('web')
                ->group(base_path('app/Dominios/Areas/Routes/web.php'));
            Route::middleware('api')
                ->prefix('v1')
                ->group(base_path('app/Dominios/Areas/Routes/api.php'));
            // =========================
            // ASIGNACIONES
            // =========================
            Route::middleware('web')
                ->group(base_path('app/Dominios/Asignaciones/Routes/web.php'));
            Route::middleware('api')
                ->prefix('v1')
                ->group(base_path('app/Dominios/Asignaciones/Routes/api.php'));
            // =========================
            // EQUIPOS
            // =========================
            Route::middleware('web')
                ->group(base_path('app/Dominios/Equipos/Routes/web.php'));
            Route::middleware('api')
                ->prefix('v1')
                ->group(base_path('app/Dominios/Equipos/Routes/api.php'));
            // =========================
            // FICHAS
            // =========================
            Route::middleware('web')
                ->group(base_path('app/Dominios/Fichas/Routes/web.php'));
            Route::middleware('api')
                ->prefix('v1')
                ->group(base_path('app/Dominios/Fichas/Routes/api.php'));
            // =========================
            // PROGRAMAS
            // =========================
            Route::middleware('web')
                ->group(base_path('app/Dominios/Programas/Routes/web.php'));
            Route::middleware('api')
                ->prefix('v1')
                ->group(base_path('app/Dominios/Programas/Routes/api.php'));
            // =========================
            // RESULTADOS
            // =========================
            Route::middleware('web')
                ->group(base_path('app/Dominios/Resultados/Routes/web.php'));
            Route::middleware('api')
                ->prefix('v1')
                ->group(base_path('app/Dominios/Resultados/Routes/api.php'));
            // =========================
            // INSCRIPCIONES
            // =========================
            Route::middleware('web')
                ->group(base_path('app/Dominios/Inscripciones/Routes/web.php'));
            Route::middleware('api')
                ->prefix('v1')
                ->group(base_path('app/Dominios/Inscripciones/Routes/api.php'));
        });
    }
}
