<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Helpers\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $shouldRenderJson = static fn(Request $request): bool => $request->is('api/*') || $request->expectsJson();

        $exceptions->render(function (ValidationException $exception, Request $request) use ($shouldRenderJson) {
            if (! $shouldRenderJson($request)) {
                return null;
            }

            return ApiResponse::validation($exception->errors());
        });

        $exceptions->render(function (AuthenticationException $exception, Request $request) use ($shouldRenderJson) {
            if (! $shouldRenderJson($request)) {
                return null;
            }

            return ApiResponse::unauthenticated();
        });

        $exceptions->render(function (HttpException $exception, Request $request) use ($shouldRenderJson) {
            if (! $shouldRenderJson($request)) {
                return null;
            }

            return match ($exception->getStatusCode()) {
                404 => ApiResponse::notFound($exception->getMessage() ?: 'Not Found.'),
                405 => ApiResponse::methodNotAllowed($exception->getMessage() ?: 'Method Not Allowed.'),
                default => ApiResponse::error(
                    $exception->getMessage() ?: 'Request failed.',
                    $exception->getStatusCode()
                ),
            };
        });

        $exceptions->render(function (\Throwable $exception, Request $request) use ($shouldRenderJson) {
            if (! $shouldRenderJson($request)) {
                return null;
            }

            return ApiResponse::serverError('Server Error.', config('app.debug')
                ? ['exception' => $exception->getMessage()]
                : null);
        });
    })->create();
