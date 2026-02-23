<?php

declare(strict_types=1);

namespace Shared\Middleware;

use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Modules\Auth\Http\Middleware\EnsureTokenNotExpired;

/**
 * Custom middleware kernel for the application.
 */
class Kernel
{
    /**
     * Get the middleware aliases for the application.
     *
     * @return array<string, class-string>
     */
    public static function alias(): array
    {
        return [
            'verified' => EnsureEmailIsVerified::class,
            'ensure.token.not.expired' => EnsureTokenNotExpired::class,
        ];
    }
}
