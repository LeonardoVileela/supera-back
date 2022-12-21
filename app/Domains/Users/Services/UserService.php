<?php

namespace App\Domains\Users\Services;

use App\Domains\Users\Repositories\UserRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws HttpResponseException
     */
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8'
            ]);
        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json(['message' => 'invalid user'], 400));
        }

        $user = $this->userRepository->create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password'])
        ]);

        return response()->json([], 201);

    }

    public function infouser(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($request->user(), 200);
    }
}
