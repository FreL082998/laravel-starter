<?php

declare(strict_types=1);

namespace Modules\User\Actions;

use Exception;
use Modules\User\Models\Role;

/**
 * UpdateRoleAction handles role update logic.
 *
 * Updates role data with optional permission changes.
 *
 * @category Action
 */
final class UpdateRoleAction
{
    /**
     * Execute the update role action.
     *
     * @param  Role  $role  The role to update
     * @param  array<string, mixed>  $data  The data to update
     * @return Role The updated role instance
     */
    public function execute(Role $role, array $data): Role
    {
        // Extract permissions from data and remove it to avoid mass assignment issues
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);

        // Update the role and sync permissions
        return tap($role->update($data) ? $role : throw new Exception(__('response.error.role.failed_to_update')), function (Role $updatedRole) use ($permissions) {
            $updatedRole->syncPermissions($permissions);
        });
    }
}
