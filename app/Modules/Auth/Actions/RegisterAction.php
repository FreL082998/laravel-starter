<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\User\Actions\CreateUserAction;
use Modules\User\Models\User;

/**
 * RegisterAction handles new user registration.
 *
 * This action creates a new user account with the provided registration details
 * and assigns the default "user" role to the new account.
 *
 * @category Authentication
 */
final class RegisterAction
{
    /**
     * Create a new instance of RegisterAction.
     *
     * @param  CreateUserAction  $createUserAction  The user creation action
     */
    public function __construct(
        private readonly CreateUserAction $createUserAction,
    ) {}

    /**
     * Execute the registration action.
     *
     * Creates a new user account with the provided data and assigns
     * the default "user" role.
     *
     * @param  array{
     *     name: string,
     *     email: string,
     *     phone: string,
     *     password: string
     * }  $data The registration data
     * @return User The newly created user instance
     */
    public function execute(array $data): User
    {
        return $this->createUserAction->execute([
            ...$data,
            'role_id' => 'user',
        ]);
    }
}
