<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// use Modules\User\Repositories\RoleRepository;
// use Modules\User\Repositories\UserRepository;

/**
 * RepositoryServiceProvider registers all repository bindings.
 *
 * This provider handles the registration of all repository classes
 * to the service container, enabling dependency injection throughout
 * the application.
 *
 * @category Service Provider
 */
final class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register repository bindings in the container.
     *
     * All repositories are registered as singletons to ensure
     * consistent instances across the application.
     */
    public function register(): void
    {
        /**
         * User repository binding
         *
         * @var UserRepository
         */
        // $this->app->singleton(UserRepository::class);

        /**
         * Role repository binding
         *
         * @var RoleRepository
         */
        // $this->app->singleton(RoleRepository::class);
    }
}
