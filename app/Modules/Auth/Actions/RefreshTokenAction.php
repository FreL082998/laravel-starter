<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Carbon\CarbonInterval;
use Modules\User\Models\User;

/**
 * RefreshTokenAction handles access token renewal.
 *
 * When an access token is expired but the refresh token is still valid,
 * this action creates a new access token for the user with the configured
 * expiration time.
 *
 * @category Authentication
 */
final class RefreshTokenAction
{
    /**
     * Execute the token refresh action.
     *
     * Creates a new access token for the user with the configured
     * expiration time (default: 15 minutes).
     *
     * @param  User  $user  The user requesting token refresh
     * @return array{access_token: string, token_type: string, expires_in: int}
     *                                                                          The new access token information
     */
    public function execute(User $user): array
    {
        /** @var \Laravel\Passport\Token $token */
        $token = $user->createToken('API Token');

        return [
            'access_token' => $token->accessToken,
            'token_type' => 'Bearer',
            'expires_in' => (int) CarbonInterval::minutes(15)->totalSeconds,
        ];
    }
}
