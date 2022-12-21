<?php

use Illuminate\Support\Facades\Route;

Route::post('/save', [\App\Domains\Cars\Http\Controllers\CarController::class, 'save'])->middleware('auth:sanctum');

