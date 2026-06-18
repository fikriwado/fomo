<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;

abstract class Controller
{
    protected function resSuccess(mixed $data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        return ApiResponse::success($data, $message, $code);
    }

    protected function resError(string $message = 'Error', int $code = 400, mixed $data = []): JsonResponse
    {
        return ApiResponse::error($message, $code, $data);
    }

    protected function resCreated(mixed $data = null, string $message = 'Created'): JsonResponse
    {
        return ApiResponse::success($data, $message, 201);
    }

    protected function resUpdated(mixed $data = null, string $message = 'Updated'): JsonResponse
    {
        return ApiResponse::success($data, $message, 200);
    }

    protected function resDeleted(mixed $data = null, string $message = 'Deleted'): JsonResponse
    {
        return ApiResponse::success($data, $message, 200);
    }
}
