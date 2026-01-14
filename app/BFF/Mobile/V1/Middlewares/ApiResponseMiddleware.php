<?php


namespace App\BFF\Mobile\V1\Middlewares;

use Closure;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseMiddleware
{

    private array $customHeaders = [

        'Content-Type' => 'application/json',
        'X-Content-Type' => 'mobile',
        'X-API-Version' => 'v1',
        'Cache-Control' => 'private, no-cache,no-store,must-revalidate',
    ];

    private function formatErrorResponse(Response $response): JsonResponse
    {
        $jsonResponse = response()->json([
            'success' => false,
            'message' => $response->exception?->getMessage() ?? 'Error desconocido',
            'code' => $response->getStatusCode(),

        ], $response->getStatusCode());

        return $this->addCustomHeaders($jsonResponse);
    }

    private function addCustomHeaders(JsonResponse $jsonResponse): JsonResponse
    {

        $jsonResponse->withHeaders($this->customHeaders);
        return $jsonResponse;
    }

    private function formatSuccessResponse(Response $response): JsonResponse
    {

        $content = json_decode($response->getContent(), true);


        $jsonResponse = response()->json([
            'success' => true,
            'data' => $content,
            'meta' => [
                'timestamp' => now()->toIso8601String(),
                'client' => 'mobile',
                'version' => 'v1',

            ]
        ], $response->getStatusCode(),
        );
        return $this->addCustomHeaders($jsonResponse);

    }

    public function handle(Request $request, Closure $next): Response
    {
        //primero obtengo la respuesta para determinar que valor retornar
        $response = $next($request);

        if (!$response->isSuccessful()) {
            return $this->formatErrorResponse($response);
        }
        return $this->formatSuccessResponse($response);
    }

}
