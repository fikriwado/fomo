<?php

use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/health', function () {
    return ApiResponse::success([], 'FOMO - Assessment Test.');
});

Route::prefix('/categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{id}', [CategoryController::class, 'show']);
});
