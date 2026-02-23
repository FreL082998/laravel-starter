<?php

declare(strict_types=1);

namespace Modules\User\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Actions\CreateUserAction;
use Modules\User\Actions\DeleteUserAction;
use Modules\User\Actions\UpdateUserAction;
use Modules\User\Http\Requests\StoreUserRequest;
use Modules\User\Http\Requests\UpdateUserRequest;
use Modules\User\Http\Resources\UserCollection;
use Modules\User\Http\Resources\UserResource;
use Modules\User\Models\User;

/**
 * UserController manages user resource operations.
 *
 * This controller handles all user-related CRUD operations and profile management endpoints.
 * Only admin users can perform CRUD operations.
 *
 * @category User Management
 */
class UserController extends Controller
{
    /**
     * Create a new instance of UserController.
     *
     * @param  CreateUserAction  $createUserAction  The user creation action
     * @param  UpdateUserAction  $updateUserAction  The user update action
     * @param  DeleteUserAction  $deleteUserAction  The user deletion action
     */
    public function __construct(
        private readonly CreateUserAction $createUserAction,
        private readonly UpdateUserAction $updateUserAction,
        private readonly DeleteUserAction $deleteUserAction,
    ) {
        // Map resource actions to UserPolicy automatically
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display all users with pagination.
     *
     * @return UserCollection<UserResource>
     */
    public function index(): UserCollection
    {
        /**
         * Retrieve paginated users
         *
         * @var \Illuminate\Pagination\Paginator $users
         */
        $users = User::paginate(15);

        return UserCollection::make($users);
    }

    /**
     * Display a specific user.
     *
     * @param  User  \Modules\User\Models\User $user
     * @return UserResource The user resource
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Create a new user.
     *
     * @param  StoreUserRequest  $request  The store user request
     * @return JsonResponse The created user resource
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        /**
         * Create new user with validated data
         *
         * @var \Modules\User\Models\User $user
         */
        $user = $this->createUserAction->execute($request->validated());

        return response()->json(new UserResource($user), 201);
    }

    /**
     * Update a user.
     *
     * @param  UpdateUserRequest  $request  The update user request
     * @param  User  $user  The user to update
     * @return UserResource The updated user resource
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        /**
         * Update user with validated data
         *
         * @var \Modules\User\Models\User $user
         */
        $user = $this->updateUserAction->execute($user, $request->validated());

        return new UserResource($user);
    }

    /**
     * Delete a user.
     *
     * @param  User  $user  The user to delete
     * @return JsonResponse Success message
     */
    public function destroy(User $user): JsonResponse
    {
        $this->deleteUserAction->execute($user);

        return response()->json(['message' => __('response.success.user.deleted')]);
    }

    /**
     * Get the authenticated user's profile.
     *
     * @param  Request  $request  The HTTP request
     * @return UserResource The authenticated user resource
     */
    public function me(Request $request): UserResource
    {
        return new UserResource($request->user());
    }
}
