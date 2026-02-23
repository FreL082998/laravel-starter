<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\User\Models\User;
use Modules\User\Observers\UserObserver;

/**
 * ObserverServiceProvider registers all model observers.
 *
 * This provider handles the registration of observers that listen
 * to model lifecycle events and execute corresponding business logic.
 *
 * @category Service Provider
 */
final class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register observer bindings for models.
     *
     * Observers are registered during the boot phase to ensure
     * they're attached to model lifecycle events.
     */
    public function boot(): void
    {
        /**
         * User observer
         *
         * Handles user model lifecycle events including registration
         * notifications and token cleanup on deletion.
         *
         * @see UserObserver
         */
        User::observe(UserObserver::class);
    }
}
