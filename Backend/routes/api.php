<?php

use App\Http\Controllers\Api\V1\Admin\RoleController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\ItemController;
use App\Http\Controllers\Api\V1\Staff\CategoryController;
use App\Http\Controllers\Api\V1\Staff\ClaimController;
use App\Http\Controllers\Api\V1\Staff\ItemController as StaffItemController;
use App\Http\Controllers\Api\V1\Student\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::middleware('throttle:auth')->group(function () {
            Route::post('/register', 'register')->name('api.v1.register');
            Route::post('/login', 'login')->name('api.v1.login');
        });

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', 'logout')->name('api.v1.logout');
            Route::get('/user', 'user')->name('api.v1.user');
        });
    });

    Route::get('/categories', [CategoryController::class, 'index'])->name('api.v1.categories.index');

    Route::controller(ItemController::class)->group(function () {
        Route::get('/items', 'index')->name('api.v1.items.index');
        Route::get('/items/{item}', 'show')->name('api.v1.items.show');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile', 'show')->name('api.v1.profile.show');
            Route::match(['put', 'patch'], '/profile', 'update')->name('api.v1.profile.update
            ');
        });

        Route::middleware('permission:items.manage,sanctum')->group(function () {
            Route::apiResource('items', StaffItemController::class)
                ->except(['index', 'show'])
                ->names('api.v1.items');
        });

        Route::controller(ClaimController::class)->group(function () {
            Route::middleware('permission:claims.moderate,sanctum')->group(function () {
                Route::get('/claims', 'index')->name('api.v1.claims.index');
                Route::patch('/claims/{claim}/status', 'updateStatus')->name('api.v1.claims.status.update');
            });
        });

        Route::controller(UserController::class)->group(function () {
            Route::get('/users', 'index')
                ->middleware('permission:users.view,sanctum')
                ->name('api.v1.user.index');

            Route::patch('/users/{user}/role', 'updateRole')
                ->middleware('permission:roles.assign,sanctum')
                ->name('api.v1.users.role.update');
        });

        Route::get('/roles', [RoleController::class, 'index'])
            ->middleware('permission:roles.view,sanctum')
            ->name('api.v1.roles.index');
    });
});
