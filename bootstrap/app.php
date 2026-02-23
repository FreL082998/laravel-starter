<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Shared\Exceptions\Handler;
use Shared\Middleware\Kernel;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->throttleApi();
        $middleware->alias(Kernel::alias());
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, Request $request) {
            return app()->make(Handler::class)->render($e, $request) ?? response()->json([
                'message' => $e->getMessage() ?? 'An error occurred',
                'debug' => config('app.debug') ? (string) $e : null,
            ], $e instanceof HttpException ? $e->getStatusCode() : 500);
        });
    })->create();
