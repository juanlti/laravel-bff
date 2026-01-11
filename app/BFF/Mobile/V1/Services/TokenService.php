<?php


namespace App\BFF\Mobile\V1\Services;


use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class TokenService
{


    public function createToken(User $user, int $expiresInMinutes = 60 * 24): string
    {
        $tokenId = Str::uuid()->toString();

        Cache::put("auth_token:{$tokenId}", $user->id, now()->addMinutes($expiresInMinutes));

        return $tokenId;

    }

    public function validateToken(string $token): ?User
    {

        $tokenUser = Cache::get("auth_token:{$token}");
        if (!$tokenUser) {
            return null;
        }
        return User::find($tokenUser->value);
    }

    public function revokeToken(?string $token = null): bool
    {
        if (!$token) {
            return false;
        }
        return Cache::forget("auth_token:{$token}");
    }

}








