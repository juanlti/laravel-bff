<?php

use App\BFF\Mobile\V1\Middlewares\ApiResponseMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\SubstituteBindings;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // creo mi propia colleccion de middlewares
        $middleware->group('bbf.mobile.v1.api',
            [
                SubstituteBindings::class,
                ApiResponseMiddleware::class,
            ]);
        //alias del middleware para la autenticacion del token
        $middleware->alias([
            'bff.mobile.v1.auth' => \App\BFF\Mobile\V1\Middlewares\EnsureIsAuthenticated::class,
        ]);
        ///dd($middleware->getMiddlewareGroups());
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
