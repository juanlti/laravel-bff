<?php

use App\BFF\Mobile\V1\Middlewares\ApiResponseMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware(['bff.mobile.v1.base'])
                ->prefix('v1')
                ->name('bff.mobile.v1.')
                ->group(base_path('routes/bff/mobile/v1.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // grupo de middlewares base para las rutas de la API mobile v1
        $middleware->group('bff.mobile.v1.base', [
            SubstituteBindings::class,
            ApiResponseMiddleware::class,
        ]);

        //alias del middleware para la autenticacion del token
        $middleware->alias([
            'bff.mobile.v1.auth' => \App\BFF\Mobile\V1\Middlewares\EnsureIsAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
