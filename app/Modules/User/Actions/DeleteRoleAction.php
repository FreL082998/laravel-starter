<?php

declare(strict_types=1);

namespace Modules\User\Actions;

use Modules\User\Models\Role;

/**
 * DeleteRoleAction handles role deletion logic.
 *
 * Permanently deletes a role from the database.
 *
 * @category Action
 */
final class DeleteRoleAction
{
    /**
     * Execute the delete role action.
     *
     * @param  Role  $role  The role to delete
     * @return bool True if deletion was successful
     */
    public function execute(Role $role): bool
    {
        return $role->delete();
    }
}
