<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnvController;

Route::get('/env-check', [EnvController::class, 'index']);

// 🚀 New Routes
Route::get('/env-validate', [EnvController::class, 'validateEnv']);
Route::get('/db-check', [EnvController::class, 'checkDatabase']);
Route::get('/toggle-debug', [EnvController::class, 'toggleDebug']);

Route::get('/', function () {
    return view('welcome');
});
