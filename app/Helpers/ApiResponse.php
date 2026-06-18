<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(mixed $data = null, string $message = 'Request successful.', int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function error(string $message = 'Request failed.', int $status = 400, mixed $errors = null): JsonResponse
    {
        return response()->json([
            'status'  => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }

    public static function validation(mixed $errors, string $message = 'Validation failed.'): JsonResponse
    {
        return static::error($message, 422, $errors);
    }

    public static function unauthenticated(string $message = 'Unauthenticated.'): JsonResponse
    {
        return static::error($message, 401);
    }

    public static function notFound(string $message = 'Resource not found.'): JsonResponse
    {
        return static::error($message, 404);
    }

    public static function methodNotAllowed(string $message = 'Method not allowed.'): JsonResponse
    {
        return static::error($message, 405);
    }

    public static function serverError(string $message = 'Internal server error.', mixed $errors = null): JsonResponse
    {
        return static::error($message, 500, $errors);
    }
}
