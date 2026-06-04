<?php

namespace App\Http\Controllers;

use App\Environment\AppEnvironment;
use App\Models\EnvHistory;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EnvController extends Controller
{
    // Added index function to fix the error
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

    public function dashboard()
    {
        $totalEdits = EnvHistory::count();
        $lastEdit = EnvHistory::latest()->first();
        return view('welcome', compact('totalEdits', 'lastEdit'));
    }

    public function update(Request $request, AppEnvironment $env)
    {
        $request->validate([
            'DB_PORT' => 'required|integer',
            'APP_DEBUG' => 'required|in:true,false',
        ]);

        $path = base_path('.env');
        $oldContent = file_get_contents($path);

        $newContent = $oldContent;
        foreach ($request->only(['DB_PORT', 'APP_DEBUG']) as $key => $value) {
            $newContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $newContent);
        }

        file_put_contents($path, $newContent);

        EnvHistory::create(['content' => $newContent]);

        ActivityLog::create([
            'user_name' => 'Admin', 
            'action' => 'Updated DB_PORT and APP_DEBUG'
        ]);

        return response()->json(['message' => 'Configuration updated successfully']);
    }

    public function validateEnv(AppEnvironment $env)
    {
        return response()->json([
            'is_production' => $env->isProduction(),
            'db_configured' => $env->isDatabaseConfigured(),
            'status' => $env->isDatabaseConfigured() ? 'OK' : 'ERROR'
        ]);
    }

    public function checkDatabase()
    {
        try {
            DB::connection()->getPdo();
            return response()->json(['database' => 'Connected successfully']);
        } catch (\Exception $e) {
            return response()->json(['database' => 'Connection failed', 'error' => $e->getMessage()], 500);
        }
    }
}