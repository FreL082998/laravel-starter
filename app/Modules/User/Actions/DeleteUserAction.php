<?php

declare(strict_types=1);

namespace Modules\User\Actions;

use Modules\User\Models\User;

/**
 * DeleteUserAction handles user deletion logic.
 *
 * Permanently deletes a user from the database.
 *
 * @category Action
 */
final class DeleteUserAction
{
    /**
     * Execute the delete user action.
     *
     * @param  User  $user  The user to delete
     * @return bool True if deletion was successful
     */
    public function execute(User $user): bool
    {
        return (bool) $user->delete();
    }
}
