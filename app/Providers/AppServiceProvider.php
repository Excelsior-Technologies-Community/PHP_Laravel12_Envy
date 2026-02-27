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
