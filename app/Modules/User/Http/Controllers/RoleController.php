<?php

declare(strict_types=1);

namespace Modules\User\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\User\Actions\CreateRoleAction;
use Modules\User\Actions\DeleteRoleAction;
use Modules\User\Actions\UpdateRoleAction;
use Modules\User\Http\Requests\StoreRoleRequest;
use Modules\User\Http\Requests\UpdateRoleRequest;
use Modules\User\Http\Resources\RoleCollection;
use Modules\User\Http\Resources\RoleResource;
use Modules\User\Models\Role;

/**
 * RoleController manages role resource operations.
 *
 * This controller handles all role-related CRUD operations and profile management endpoints.
 * Only admin users can perform CRUD operations.
 *
 * @category Role Management
 */
class RoleController extends Controller
{
    /**
     * Create a new instance of RoleController.
     *
     * @param  CreateRoleAction  $createRoleAction  The role creation action
     * @param  UpdateRoleAction  $updateRoleAction  The role update action
     * @param  DeleteRoleAction  $deleteRoleAction  The role deletion action
     */
    public function __construct(
        private CreateRoleAction $createRoleAction,
        private UpdateRoleAction $updateRoleAction,
        private DeleteRoleAction $deleteRoleAction,
    ) {
        // Map resource actions to RolePolicy automatically
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display all roles with pagination.
     *
     * @return RoleCollection<RoleResource>
     */
    public function index(): RoleCollection
    {
        /**
         * Retrieve paginated roles
         *
         * @var \Illuminate\Pagination\Paginator $roles
         */
        $roles = Role::paginate(15);

        return RoleCollection::make($roles);
    }

    /**
     * Display a specific role.
     *
     * @param  Role  \Modules\User\Models\Role $role
     * @return RoleResource The role resource
     */
    public function show(Role $role): RoleResource
    {
        return new RoleResource($role);
    }

    /**
     * Create a new role.
     *
     * @param  StoreRoleRequest  $request  The store role request
     * @return JsonResponse The created role resource
     */
    public function store(StoreRoleRequest $request): JsonResponse
    {
        /**
         * Create new role with validated data
         *
         * @var \Modules\User\Models\Role $role
         */
        $role = $this->createRoleAction->execute($request->validated());

        return response()->json(new RoleResource($role), 201);
    }

    /**
     * Update a role.
     *
     * @param  UpdateRoleRequest  $request  The update role request
     * @param  Role  $role  The role to update
     * @return RoleResource The updated role resource
     */
    public function update(UpdateRoleRequest $request, Role $role): RoleResource
    {
        /**
         * Update role with validated data
         *
         * @var \Modules\User\Models\Role $role
         */
        $role = $this->updateRoleAction->execute($role, $request->validated());

        return new RoleResource($role);
    }

    /**
     * Delete a role.
     *
     * @param  Role  $role  The role to delete
     * @return JsonResponse Success message
     */
    public function destroy(Role $role): JsonResponse
    {
        $this->deleteRoleAction->execute($role);

        return response()->json(['message' => __('response.success.role.deleted')]);
    }
}
