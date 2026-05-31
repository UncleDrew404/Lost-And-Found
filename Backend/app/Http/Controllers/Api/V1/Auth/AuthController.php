<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\V1\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(UserRegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return $this->created([
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ], $result['message']);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->validated());

        if (! $result['success']) {
            return $this->error($result['message'], $result['status_code'] ?? 400);
        }

        return $this->success([
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ], $result['message']);
    }

    public function user(Request $request): JsonResponse
    {
        return $this->success(
            new UserResource($request->user()->load(['roles.permissions', 'userProfile'])),
            'User retrieved successfully'
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request);

        return $this->success(null, 'Logged out successfully');
    }
}
