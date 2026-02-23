<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;
use RuntimeException;

/**
 * LoginAction handles user authentication.
 *
 * This action validates user credentials and returns an authenticated user
 * if the provided password matches the stored hash.
 *
 * @category Authentication
 */
final class LoginAction
{
    /**
     * Execute the login action.
     *
     * Authenticates a user with the provided email and password.
     * Returns the authenticated user if credentials are valid.
     *
     * @param  string  $email  The user's email address
     * @param  string  $password  The user's password in plain text
     * @return User The authenticated user instance
     *
     * @throws RuntimeException If credentials are invalid
     */
    public function execute(string $email, string $password): User
    {
        /** @var User|null $user */
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw new RuntimeException(__('response.error.auth.invalid_credentials'));
        }

        return $user;
    }
}
