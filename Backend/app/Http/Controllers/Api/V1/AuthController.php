<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends BaseController
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(UserRegisterRequest $request)
    {
        $validatedData = $request->validated();

        $user = $this->authService->register($validatedData);

        return $this->created($user, 'User registered successfully');
    }

    public function login(UserLoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        return $this->success([
            'user' => $result['user'],
            'token' => $result['token'],
        ], $result['message']);

        // if (!$result['success']) {
        //     $statusCode = $result['message'] === 'Invalid credentials' ? 401 : 403;
        //     return $this->error($result['message'], $statusCode);
        // }
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return $this->success(null, 'Logged out successfully');
    }
}

