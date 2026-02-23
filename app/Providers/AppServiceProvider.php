<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

/**
 * AppServiceProvider bootstraps core application services.
 *
 * This provider handles general application configuration and
 * bootstrapping. Specific service registrations are delegated to
 * specialized service providers.
 *
 * @category Service Provider
 */
final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * This method is called before other service providers to
     * register core application bindings.
     */
    public function register(): void
    {
        // Core application services registered here
    }

    /**
     * Bootstrap any application services.
     *
     * This method is called after all services are registered
     * and is used to configure application behavior.
     */
    public function boot(): void
    {
        /**
         * Force HTTPS in production
         *
         * Ensures all generated URLs use HTTPS scheme
         * for security in production environments.
         */
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        /**
         * Configure API rate limiter
         *
         * Limits API requests to 60 per minute per authenticated user
         * or per IP address for unauthenticated requests.
         */
        RateLimiter::for('api', function (Request $request): \Illuminate\Cache\RateLimiting\Limit {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(60)->by(
                $request->user()?->id ?: $request->ip(),
            );
        });
    }
}
