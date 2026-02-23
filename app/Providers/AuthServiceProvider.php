<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\CarbonInterval;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

/**
 * AuthServiceProvider configures authentication and Passport.
 *
 * This provider handles the registration and configuration of authentication
 * mechanisms, including Passport token expiration settings.
 *
 * @category Service Provider
 */
final class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register authentication services.
     */
    public function register(): void
    {
        // Register any authentication services
    }

    /**
     * Bootstrap authentication services.
     *
     * Configures Passport token lifetimes and encryption keys.
     */
    public function boot(): void
    {
        /**
         * Configure access token lifetime
         *
         * Access tokens expire after 15 minutes, requiring refresh
         * tokens to obtain new tokens without re-authenticating.
         */
        Passport::tokensExpireIn(CarbonInterval::minutes(15));

        /**
         * Configure refresh token lifetime
         *
         * Refresh tokens expire after 1 day (24 hours), after which
         * users must log in again to obtain new tokens.
         */
        Passport::refreshTokensExpireIn(CarbonInterval::days(1));

        /**
         * Configure personal access token lifetime
         *
         * Personal access tokens can be used for long-lived API
         * integrations and expire after 6 months.
         */
        Passport::personalAccessTokensExpireIn(CarbonInterval::months(6));
    }
}
