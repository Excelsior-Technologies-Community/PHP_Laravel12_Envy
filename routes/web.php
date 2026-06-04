<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnvController;

// 🔹 Dashboard Route
Route::get('/', [EnvController::class, 'dashboard']);

// 🔹 Env Check API Routes
Route::get('/env-check', [EnvController::class, 'index']);
Route::get('/env-validate', [EnvController::class, 'validateEnv']);
Route::get('/db-check', [EnvController::class, 'checkDatabase']);

// 🔹 Action Routes (Update & Toggle)
Route::post('/env-update', [EnvController::class, 'update']);
Route::get('/toggle-debug', [EnvController::class, 'toggleDebug']);