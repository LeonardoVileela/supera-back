<?php

namespace App\Domains\Users\Http\Controllers;

use App\Domains\Users\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->userService->register($request);
    }

    public function infouser(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->userService->infouser($request);
    }
}
