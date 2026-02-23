<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Auth\Actions\RefreshTokenAction;

/**
 * EnsureTokenNotExpired checks if the access token is expired.
 *
 * If the token is expired but the refresh token is valid, this middleware
 * automatically renews the access token and includes the new token in the
 * response headers.
 *
 * @category Middleware
 */
final class EnsureTokenNotExpired
{
    /**
     * Create a new instance of the middleware.
     *
     * @param  RefreshTokenAction  $refreshTokenAction  The token refresh action
     */
    public function __construct(
        private readonly RefreshTokenAction $refreshTokenAction,
    ) {}

    /**
     * Handle an incoming request.
     *
     * Checks if the current access token is expired. If it is but the
     * refresh token is still valid, automatically renews the access token
     * and includes it in the response.
     *
     * @param  Request  $request  The incoming request
     * @param  Closure(Request): Response  $next  The next middleware
     * @return Response The response with potentially new token headers
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // Check if user is authenticated and has a token
        if ($request->user()) {
            /** @var \Laravel\Passport\Token|null $token */
            $token = $request->user()->currentAccessToken();

            // If token exists and is expired
            if ($token && $token->expired()) {
                // Refresh the token and include in response header
                /** @var array{access_token: string, token_type: string, expires_in: int} $newToken */
                $newToken = $this->refreshTokenAction->execute($request->user());

                /**
                 * Add new token to response header
                 *
                 * The client should use this header to update their stored token.
                 * This allows seamless authentication without interrupting the request.
                 */
                $response->header('X-New-Access-Token', $newToken['access_token']);
                $response->header('X-Token-Expires-In', (string) $newToken['expires_in']);
            }
        }

        return $response;
    }
}
