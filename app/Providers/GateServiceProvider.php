<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\User\Models\Role;
use Modules\User\Models\User;
use Modules\User\Policies\RolePolicy;
use Modules\User\Policies\UserPolicy;

/**
 * GateServiceProvider registers authorization policies and gates.
 *
 * This provider handles the registration of policies and custom
 * authorization gates for protecting application resources.
 *
 * @category Service Provider
 */
final class GateServiceProvider extends ServiceProvider
{
    /**
     * Register authorization policies and gates.
     *
     * Policies are registered during the boot phase to ensure
     * they're available for authorization checks throughout the application.
     */
    public function boot(): void
    {
        /**
         * User policy registration
         *
         * Handles authorization for user-related actions
         * including viewing, creating, updating, and deleting.
         *
         * @see UserPolicy
         */
        Gate::policy(User::class, UserPolicy::class);

        /**
         * Role policy registration
         *
         * Handles authorization for role-related actions
         * including viewing, creating, updating, and deleting.
         *
         * @see RolePolicy
         */
        Gate::policy(Role::class, RolePolicy::class);
    }
}
