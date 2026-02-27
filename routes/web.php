<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnvController;

Route::get('/env-check', [EnvController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});
