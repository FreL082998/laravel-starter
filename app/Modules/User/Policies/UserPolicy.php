<?php

declare(strict_types=1);

namespace Modules\User\Policies;

use Modules\User\Models\User;

/**
 * UserPolicy handles authorization for user-related operations.
 *
 * Only users with the admin role can perform CRUD operations on users.
 *
 * @category Authorization
 */
final class UserPolicy
{
    /**
     * Determine if the user can view any users.
     *
     * @param  User  $user  The authenticated user
     * @return bool True if the user has admin role
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can view a specific user.
     *
     * @param  User  $user  The authenticated user
     * @param  User  $model  The user being viewed
     * @return bool True if the user has admin role
     */
    public function view(User $user, User $model): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can create users.
     *
     * @param  User  $user  The authenticated user
     * @return bool True if the user has admin role
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can update a specific user.
     *
     * @param  User  $user  The authenticated user
     * @param  User  $model  The user being updated
     * @return bool True if the user has admin role
     */
    public function update(User $user, User $model): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can delete a specific user.
     *
     * @param  User  $user  The authenticated user
     * @param  User  $model  The user being deleted
     * @return bool True if the user has admin role
     */
    public function delete(User $user, User $model): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can restore a specific user.
     *
     * @param  User  $user  The authenticated user
     * @param  User  $model  The user being restored
     * @return bool True if the user has admin role
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can permanently delete a specific user.
     *
     * @param  User  $user  The authenticated user
     * @param  User  $model  The user being force deleted
     * @return bool True if the user has admin role
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasRole('admin');
    }
}
