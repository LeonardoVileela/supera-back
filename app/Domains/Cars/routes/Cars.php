<?php

use Illuminate\Support\Facades\Route;

Route::post('/save', [\App\Domains\Cars\Http\Controllers\CarController::class, 'save'])->middleware('auth:sanctum');
Route::get('/all/{id}', [\App\Domains\Cars\Http\Controllers\CarController::class, 'all'])->middleware('auth:sanctum');
Route::get('/maintenance', [\App\Domains\Cars\Http\Controllers\CarController::class, 'closeToMaintenanceDate'])->middleware('auth:sanctum');
Route::put('/update/{id}', [\App\Domains\Cars\Http\Controllers\CarController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/delete/{id}', [\App\Domains\Cars\Http\Controllers\CarController::class, 'delete'])->middleware('auth:sanctum');

