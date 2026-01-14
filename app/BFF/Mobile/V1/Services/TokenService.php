<?php


namespace App\BFF\Mobile\V1\Services;


use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TokenService
{


    public function createToken(User $user, int $expiresInMinutes = 60 * 24): string
    {
        $tokenId = Str::uuid()->toString();

        Log::info('TokenService: Creando token', [
            'token' => $tokenId,
            'user_id' => $user->id,
            'expires_in_minutes' => $expiresInMinutes
        ]);

        Cache::put("auth_token:{$tokenId}", $user->id, now()->addMinutes($expiresInMinutes));

        // Verificar que se guardó correctamente
        $verificacion = Cache::get("auth_token:{$tokenId}");
        Log::info('TokenService: Verificación después de guardar', [
            'token' => $tokenId,
            'valor_guardado' => $verificacion
        ]);

        return $tokenId;

    }

    public function validateToken(string $token): ?User
    {
        Log::info('TokenService: Validando token', [
            'token_recibido' => $token,
            'cache_key' => "auth_token:{$token}"
        ]);

        $userId = Cache::get("auth_token:{$token}");
        
        Log::info('TokenService: Resultado del cache', [
            'userId' => $userId,
            'tipo' => gettype($userId)
        ]);

        if (!$userId) {
            Log::warning('TokenService: Token no encontrado en cache');
            return null;
        }

        $user = User::find($userId);
        
        Log::info('TokenService: Usuario encontrado', [
            'user_id' => $user?->id,
            'user_email' => $user?->email
        ]);

        return $user;
    }

    public function revokeToken(?string $token = null): bool
    {
        if (!$token) {
            return false;
        }
        
        Log::info('TokenService: Revocando token', ['token' => $token]);
        
        return Cache::forget("auth_token:{$token}");
    }

}