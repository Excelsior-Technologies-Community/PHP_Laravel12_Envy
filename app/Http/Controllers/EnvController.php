<?php

namespace App\Http\Controllers;

use App\Environment\AppEnvironment;
use Illuminate\Support\Facades\DB;

class EnvController extends Controller
{
    // 🔹 Basic Info
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

    // 🚀 1. ENV VALIDATION
    public function validateEnv(AppEnvironment $env)
    {
        return response()->json([
            'is_production' => $env->isProduction(),
            'db_configured' => $env->isDatabaseConfigured(),
            'status' => $env->isDatabaseConfigured() ? 'OK' : 'ERROR'
        ]);
    }

    // 🚀 2. DATABASE CONNECTION CHECK
    public function checkDatabase()
    {
        try {
            DB::connection()->getPdo();

            return response()->json([
                'database' => 'Connected successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'database' => 'Connection failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // 🚀 3. DEBUG TOGGLE (VERY IMPRESSIVE)
    public function toggleDebug(AppEnvironment $env)
    {
        $current = $env->APP_DEBUG ? 'true' : 'false';
        $newValue = $env->APP_DEBUG ? 'false' : 'true';

        $path = base_path('.env');
        $content = file_get_contents($path);

        $content = preg_replace(
            '/APP_DEBUG=.*/',
            'APP_DEBUG=' . $newValue,
            $content
        );

        file_put_contents($path, $content);

        return response()->json([
            'message' => "Debug changed from $current to $newValue"
        ]);
    }
}