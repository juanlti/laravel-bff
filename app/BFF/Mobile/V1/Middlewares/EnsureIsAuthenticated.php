<?php

namespace App\BFF\Mobile\V1\Middlewares;


use App\BFF\Mobile\V1\Services\TokenService;
use Closure;
use Illuminate\Http\Client\Request;
use Illuminate\Validation\UnauthorizedException;

class EnsureIsAuthenticated
{


    public function __construct(protected TokenService $tokenService)
    {


    }


    //este middleware es el punto de entrada
    public function handle(Request $request, Closure $next): mixed
    {
        //el token viene en las cabeceras
        $token = $request->bearerToken();
        if (!$token) {
            throw new UnauthorizedException(challange: '', message: 'No autorizado');
        }

        $user = $this->tokenService->validateToken($token);
        if (!$user) {
            throw new UnauthorizedException(challange: '', message: 'Token invalido o expirado');
        }

        //utilizamos inyeccion de dependencias en el request, es decir que en el punto de entrada agregamos el usuario obtenido a partit del token en el request
        // y disponemos de dicha informacion para los middlewares que este mas adelantes, controladores.
        // ejemplo de uso del user en un controlador:  $request()->user();

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}
