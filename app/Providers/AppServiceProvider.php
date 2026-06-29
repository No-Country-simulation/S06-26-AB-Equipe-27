<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Enforce HTTPS only in production environments
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }
    }
}
