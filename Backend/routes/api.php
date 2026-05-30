<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ItemController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware('throttle:auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('api.v1.register');
        Route::post('/login', [AuthController::class, 'login'])->name('api.v1.login');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('api.v1.logout');
        Route::get('/user', [AuthController::class, 'user'])->name('api.v1.user');

        Route::middleware('permission:items.view,sanctum')->group(function () {
            Route::get('/items', [ItemController::class, 'index'])->name('api.v1.items.index');
            Route::get('/items/{item}', [ItemController::class, 'show'])->name('api.v1.items.show');
        });

        Route::middleware('permission:items.manage,sanctum')->group(function () {
            Route::apiResource('items', ItemController::class)->except(['index', 'show'])->names('api.v1.items');
        });

        Route::get('/users', [UserController::class, 'index'])
            ->middleware('permission:users.view,sanctum')
            ->name('api.v1.user.index');

        Route::get('/roles', [RoleController::class, 'index'])
            ->middleware('permission:roles.view,sanctum')
            ->name('api.v1.roles.index');

        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])
            ->middleware('permission:roles.assign,sanctum')
            ->name('api.v1.users.role.update');
    });
});
