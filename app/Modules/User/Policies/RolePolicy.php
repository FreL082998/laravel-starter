<?php

declare(strict_types=1);

namespace Modules\User\Policies;

use Modules\User\Models\Role;
use Modules\User\Models\User;

/**
 * RolePolicy handles authorization for role-related operations.
 *
 * Only users with the admin role can perform CRUD operations on roles.
 *
 * @category Authorization
 */
final class RolePolicy
{
    /**
     * Determine if the user can view any roles.
     *
     * @param  User  $user  The authenticated user
     * @return bool True if the user has admin role
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can view a specific role.
     *
     * @param  User  $user  The authenticated user
     * @param  Role  $model  The role being viewed
     * @return bool True if the user has admin role
     */
    public function view(User $user, Role $model): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can create roles.
     *
     * @param  User  $user  The authenticated user
     * @return bool True if the user has admin role
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can update a specific role.
     *
     * @param  User  $user  The authenticated user
     * @param  Role  $model  The role being updated
     * @return bool True if the user has admin role
     */
    public function update(User $user, Role $model): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can delete a specific role.
     *
     * @param  User  $user  The authenticated user
     * @param  Role  $model  The role being deleted
     * @return bool True if the user has admin role
     */
    public function delete(User $user, Role $model): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can restore a specific role.
     *
     * @param  User  $user  The authenticated user
     * @param  Role  $model  The role being restored
     * @return bool True if the user has admin role
     */
    public function restore(User $user, Role $model): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can permanently delete a specific role.
     *
     * @param  User  $user  The authenticated user
     * @param  Role  $model  The role being force deleted
     * @return bool True if the user has admin role
     */
    public function forceDelete(User $user, Role $model): bool
    {
        return $user->hasRole('admin');
    }
}
