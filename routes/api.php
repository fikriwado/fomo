<?php

use Illuminate\Support\Facades\Route;
use App\Helpers\ApiResponse;

Route::get('/health', function () {
    return ApiResponse::success([], 'FOMO - Assessment Test.');
});
