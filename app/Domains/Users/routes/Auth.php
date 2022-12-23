<?php

use App\Domains\Users\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/authenticated', [AuthController::class, 'isAuthenticated'])->middleware('auth:sanctum');

