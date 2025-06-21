<?php

namespace App\Providers;

use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // //
        // if (app()->environment('production')) {
        //     URL::forceScheme('https');
        // }
        
        app('router')->aliasMiddleware('admin', Admin::class);
    }
}
