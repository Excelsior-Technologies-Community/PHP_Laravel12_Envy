<?php

namespace App\Http\Controllers;

use App\Environment\AppEnvironment;

class EnvController extends Controller
{
    public function index(AppEnvironment $env)
    {
        return response()->json([
            'App Name' => $env->APP_NAME,
            'Environment' => $env->APP_ENV,
            'Debug Mode' => $env->APP_DEBUG,
            'Database Host' => $env->DB_HOST,
            'Database Port' => $env->DB_PORT,
        ]);
    }
}