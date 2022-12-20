<?php

namespace App\Domains\Users\Http\Controllers;


use App\Domains\Users\Services\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
       return $this->authService->login($request);
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->authService->logout($request);
    }
}
