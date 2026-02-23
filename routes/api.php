<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\User\Http\Controllers\RoleController;
use Modules\User\Http\Controllers\UserController;

/**
 * Public Authentication Routes
 *
 * These routes are accessible without authentication.
 */
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

/**
 * Authenticated API Routes
 *
 * All routes in this group require valid access token authentication.
 * The EnsureTokenNotExpired middleware automatically refreshes expired
 * tokens when valid refresh tokens are available.
 */
Route::middleware(['auth:api', 'ensure.token.not.expired'])->group(function (): void {
    // Authentication routes
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/auth/refresh', [AuthController::class, 'refresh'])->name('auth.refresh');

    // User management routes
    Route::get('/me', [UserController::class, 'me'])->name('user.me');
    Route::apiResource('users', UserController::class);

    // Role management routes
    Route::apiResource('roles', RoleController::class);
});
