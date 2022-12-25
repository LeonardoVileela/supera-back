<?php

namespace App\Domains\Users\Services;


use App\Domains\Users\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Invalid login details'], 401);
        }

        $user = $this->userRepository->getByEmail($request['email']);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {

        // delete all tokens, essentially logging the user out
        //$request->user()->tokens()->delete();
        $request->user()->currentAccessToken()->delete();
        return response()->json();

        // delete the current token that was used for the request
        //$request->user()->currentAccessToken()->delete();
    }

    public function isAuthenticated(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json();
    }
}
