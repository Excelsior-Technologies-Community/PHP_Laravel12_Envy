# PHP_Laravel12_Envy

## Project Introduction

PHP_Laravel12_Envy is a Laravel 12 demonstration project that showcases structured and type-safe environment configuration management using the worksome/envy package.

The project demonstrates how to:

- Install and configure Envy in a Laravel 12 application

- Maintain a clean .env.example file

- Automatically sync environment variables from configuration files

- Remove unused environment variables

- Implement a strongly-typed Environment Data Transfer Object (DTO)

- Inject environment configuration using Laravel’s service container

This project combines Envy’s configuration management capabilities with Laravel’s dependency injection system to build a cleaner and more maintainable environment architecture.

---

## Project Overview

This project demonstrates:

- Installing Laravel 12

- Installing Envy (official method)

- Running envy:install

- Using envy:sync

- Using envy:prune

- Creating a typed environment class

- Injecting environment via dependency injection

- Validating environment variables automatically

---

## Step 1: Create Laravel 12 Project

```bash
composer create-project laravel/laravel PHP_Laravel12_Envy "12.*"
```

Move into project:

```bash
cd PHP_Laravel12_Envy
```

Run server:

```bash
php artisan serve
```

---

## Step 2: Install Envy (Official Method)

Install as development dependency:

```bash
composer require worksome/envy --dev
```

---

## Step 3: Install Envy Configuration

Run:

```bash
php artisan envy:install
```

This command:

- Publishes the configuration file

- Prepares Envy for usage

- Sets up default structure

---

## Step 4: Sync Environment Variables

Run:

```bash
php artisan envy:sync
```

What this does:

- Syncs your .env file with your Envy classes

- Ensures required variables exist

- Validates types

- Updates environment safely

---

## Step 5: Prune Unused Variables

Run:

```bash
php artisan envy:prune
```

What this does:

- Removes unused environment variables

- Cleans old configuration

- Prevents clutter in .env

---

## Step 6: Create Environment Class

Create folder:

```
app/Environment
```

Create file:

```
app/Environment/AppEnvironment.php
```

app/Environment/AppEnvironment.php

```php
<?php

namespace App\Environment;

class AppEnvironment
{
    public function __construct(
        public string $APP_NAME,
        public string $APP_ENV,
        public bool $APP_DEBUG,
        public string $APP_URL,

        public string $DB_CONNECTION,
        public string $DB_HOST,
        public int $DB_PORT,
        public string $DB_DATABASE,
        public string $DB_USERNAME,
        public string $DB_PASSWORD,
    ) {}
}
```
---

## Step 7: Bind Environment Class in Service Provider

Open:

```
app/Providers/AppServiceProvider.php
```

Update register() method:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Environment\AppEnvironment;
use Worksome\Envy\Envy;
use Worksome\Envy\EnvyServiceProvider;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
public function register(): void
{
    $this->app->singleton(AppEnvironment::class, function () {

        $default = config('database.default');
        $db = config("database.connections.$default");

        return new AppEnvironment(
            config('app.name'),
            config('app.env'),
            config('app.debug'),
            config('app.url'),

            $default,
            $db['host'],
            (int) $db['port'],
            $db['database'],
            $db['username'],
            $db['password'],
        );
    });
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
```

---

## Step 8: Create Controller

Create controller:

```bash
php artisan make:controller EnvController
```

app/Http/Controllers/EnvController.php

```php
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
```

---

## Step 9: Add Route

Open:

```
routes/web.php
```

Add:

```php
use App\Http\Controllers\EnvController;

Route::get('/env-check', [EnvController::class, 'index']);
```

---

## Step 10: Test Project

Run:

```bash
php artisan serve
```

Visit:

```bash
http://127.0.0.1:8000/env-check
```

You will see structured JSON output.

Now check in cmd:

```bash
php artisan envy:sync
php artisan envy:prune
```

---

## Output

<img width="1823" height="1090" alt="Screenshot 2026-02-27 152230" src="https://github.com/user-attachments/assets/f7bee194-282f-4e29-915f-432d6c164315" />

<img width="1909" height="313" alt="Screenshot 2026-02-27 152415" src="https://github.com/user-attachments/assets/dc7d0289-aebd-4171-8618-0fc340ea7948" />

---

## Project Structure

```
PHP_Laravel12_Envy
│
├── app
│   ├── Environment
│   │   └── AppEnvironment.php
│   │
│   ├── Http
│   │   └── Controllers
│   │       └── EnvController.php
│   │
│   └── Providers
│       └── AppServiceProvider.php
│
├── routes
│   └── web.php
│
├── config
│   └── envy.php
│
├── .env
├── composer.json
└── README.md
```

---

Your PHP_Laravel12_Envy Project is now ready!             

