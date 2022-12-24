<?php

use Illuminate\Support\Facades\Route;

Route::post('/save/{id}', [\App\Domains\Maintenances\Http\Controllers\MaintenanceController::class, 'save'])->middleware('auth:sanctum');
Route::get('/all/{id}', [\App\Domains\Maintenances\Http\Controllers\MaintenanceController::class, 'all'])->middleware('auth:sanctum');
