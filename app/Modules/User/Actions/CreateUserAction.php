<?php

declare(strict_types=1);

namespace Modules\User\Actions;

use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;

/**
 * CreateUserAction handles user creation logic.
 *
 * Creates a new user with hashed password and assigns default role if specified.
 *
 * @category Action
 */
final class CreateUserAction
{
    /**
     * Execute the create user action.
     *
     * @param  array<string, mixed>  $data  The user data (name, email, phone, password, role)
     * @return User The created user instance
     */
    public function execute(array $data): User
    {
        /** @var string $password */
        $data['password'] = Hash::make($data['password']);

        /** @var User $user */
        $user = User::create($data);

        // Assign default role if specified
        if (isset($data['role'])) {
            $user->assignRole($data['role']);
        }

        return $user;
    }
}
