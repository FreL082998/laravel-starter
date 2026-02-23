<?php

declare(strict_types=1);

namespace Modules\User\Actions;

use Exception;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;

/**
 * UpdateUserAction handles user update logic.
 *
 * Updates user data with optional password change.
 *
 * @category Action
 */
final class UpdateUserAction
{
    /**
     * Execute the update user action.
     *
     * @param  string  $userId  The user ID to update
     * @param  array<string, mixed>  $data  The data to update
     * @return User The updated user instance
     */
    public function execute(User $user, array $data): User
    {
        // Check if user exists
        if (! $user) {
            throw new Exception(__('user.not_found'));
        }

        // Remove password if not provided
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            /** @var string $password */
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return $user;
    }
}
