<?php

declare(strict_types=1);

namespace Modules\User\Actions;

use Modules\User\Models\Role;

/**
 * CreateRoleAction handles role creation logic.
 *
 * Creates a new role with permissions.
 *
 * @category Action
 */
final class CreateRoleAction
{
    /**
     * Execute the create role action.
     *
     * @param  array<string, mixed>  $data  The role data (name, description, permissions)
     * @return Role The created role instance
     */
    public function execute(array $data): Role
    {
        // Extract permissions from data and remove it to avoid mass assignment issues
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);

        // Create the role and sync permissions
        return tap(Role::create($data), function (Role $role) use ($permissions) {
            $role->syncPermissions($permissions);
        });
    }
}
