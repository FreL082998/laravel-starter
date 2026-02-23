<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Auth\Actions\LoginAction;
use Modules\Auth\Actions\LogoutAction;
use Modules\Auth\Actions\RefreshTokenAction;
use Modules\Auth\Actions\RegisterAction;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\User\Http\Resources\UserResource;

/**
 * AuthController handles all authentication-related operations.
 *
 * This controller provides endpoints for user registration, login, logout,
 * and token refresh operations.
 *
 * @category Authentication
 */
final class AuthController
{
    /**
     * Create a new instance of AuthController.
     *
     * @param  RegisterAction  $registerAction  The registration action
     * @param  LoginAction  $loginAction  The login action
     * @param  LogoutAction  $logoutAction  The logout action
     * @param  RefreshTokenAction  $refreshTokenAction  The token refresh action
     */
    public function __construct(
        private readonly RegisterAction $registerAction,
        private readonly LoginAction $loginAction,
        private readonly LogoutAction $logoutAction,
        private readonly RefreshTokenAction $refreshTokenAction,
    ) {}

    /**
     * Register a new user.
     *
     * Creates a new user account and returns an access token for immediate authentication.
     *
     * @param  RegisterRequest  $request  The register request containing user data
     * @return JsonResponse The registered user and access token
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        /** @var \Modules\User\Models\User $user */
        $user = $this->registerAction->execute($request->validated());

        /** @var \Laravel\Passport\Token $token */
        $token = $user->createToken('API Token');

        return response()->json([
            'message' => __('response.success.auth.registered'),
            'user' => new UserResource($user),
            'access_token' => $token->accessToken,
            'token_type' => 'Bearer',
        ], 201);
    }

    /**
     * Login user with credentials.
     *
     * Authenticates a user with provided email and password, returning an access token.
     *
     * @param  LoginRequest  $request  The login request containing credentials
     * @return JsonResponse The authenticated user and access token
     */
    public function login(LoginRequest $request): JsonResponse
    {
        /** @var \Modules\User\Models\User $user */
        $user = $this->loginAction->execute(
            $request->validated('email'),
            $request->validated('password'),
        );

        /** @var \Laravel\Passport\Token $token */
        $token = $user->createToken('API Token');

        return response()->json([
            'message' => __('response.success.auth.logged_in'),
            'user' => new UserResource($user),
            'access_token' => $token->accessToken,
            'token_type' => 'Bearer',
        ], 200);
    }

    /**
     * Logout the authenticated user.
     *
     * Revokes all active tokens for the current user.
     *
     * @param  Request  $request  The HTTP request
     * @return JsonResponse Success message
     */
    public function logout(Request $request): JsonResponse
    {
        $this->logoutAction->execute($request->user());

        return response()->json([
            'message' => __('response.success.auth.logged_out'),
        ], 200);
    }

    /**
     * Refresh the access token.
     *
     * Creates a new access token when the refresh token is still valid.
     *
     * @param  Request  $request  The HTTP request
     * @return JsonResponse The new access token
     */
    public function refresh(Request $request): JsonResponse
    {
        /** @var array{access_token: string, token_type: string, expires_in: int} $tokenData */
        $tokenData = $this->refreshTokenAction->execute($request->user());

        return response()->json($tokenData, 200);
    }
}
