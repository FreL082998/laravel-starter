<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\User\Models\User;

/**
 * LogoutAction handles user session termination.
 *
 * This action revokes all active API tokens for the authenticated user,
 * effectively logging them out from all devices.
 *
 * @category Authentication
 */
final class LogoutAction
{
    /**
     * Execute the logout action.
     *
     * Revokes all active access tokens for the user.
     *
     * @param  User  $user  The user to logout
     * @return bool True if logout was successful
     */
    public function execute(User $user): bool
    {
        $user->tokens()->delete();

        return true;
    }
}
