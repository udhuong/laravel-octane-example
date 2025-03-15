<?php

use Core\Presentation\Http\Controllers\AuthController;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

Route::middleware([
    EnsureFrontendRequestsAreStateful::class, // Middleware Sanctum cho SPA
    'throttle:api',
    SubstituteBindings::class,
])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('auth')->group(function () {
            Route::get('detail', [AuthController::class, 'detail']);
            Route::post('logout', [AuthController::class, 'logout']);
        });
    });
});
