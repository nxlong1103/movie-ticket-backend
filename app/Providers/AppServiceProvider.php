<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

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
        // Định nghĩa Rate Limiter cho API
        RateLimiter::for('api', function ($request) {
            return Limit::perMinute(60); // Giới hạn 60 request/phút
        });
    }
}
