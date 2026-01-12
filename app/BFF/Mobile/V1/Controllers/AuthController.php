<?php

namespace App\BFF\Mobile\V1\Controllers;


use App\BFF\Mobile\V1\Services\TokenService;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthController extends Controller
{


    public function __construct(public TokenService $tokenService)
    {

    }

    public function login(Request $request): array
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {

            throw new UnauthorizedHttpException(challenge: '', message: 'Credenciales invalidas');
        }

        $token = $this->tokenService->createToken(user: $user);
        return [
            'token' => $token,
            'user' => $user->only(['id', 'name', 'email'])];
    }

    public function logout(Request $request): array
    {
        $this->tokenService->revokeToken(token: $request->bearerToken());

        return ['message' => 'Session cerrada correctamente'];
    }

    public function me(Request $request):array
    {
        return ['user'=>$request->user()->only(['id','name','email'])];
    }


}