<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Users\Http\Controllers\UserController;

Route::post('/register', [UserController::class, 'register']);
Route::get('/infouser', [UserController::class, 'infouser'])->middleware('auth:sanctum');
