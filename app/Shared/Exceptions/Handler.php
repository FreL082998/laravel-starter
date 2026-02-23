<?php

declare(strict_types=1);

namespace Shared\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

/**
 * Custom exception handler for the application.
 */
class Handler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|null
     */
    public function render(Throwable $e, Request $request)
    {
        if ($request->expectsJson()) {
            if ($e instanceof HttpException) {
                return response()->json([
                    'message' => $e->getMessage() ?? 'An error occurred',
                    'status' => $e->getStatusCode(),
                ], $e->getStatusCode());
            }

            if ($e instanceof ValidationException) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            }

            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'message' => 'Unauthenticated',
                ], 401);
            }

            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], 403);
            }

            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'message' => 'Resource not found',
                ], 404);
            }

            return response()->json([
                'message' => 'An error occurred',
                'debug' => config('app.debug') ? (string) $e : null,
            ], 500);
        }
    }
}
