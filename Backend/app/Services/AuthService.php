<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthService
{
    public function register(array $data): array
    {
        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'status' => 'active',
        ]);


        return [
            'success' => true,
            'user' => $user,
            'message' => 'User registered successfully',
        ];
    }

    public function login(array $credentials): array
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return [
                'success' => false,
                'message' => 'Invalid credentials',
                'status_code' => 401,
            ];
        }

        if ($user->status !== 'active') {
            return [
                'success' => false,
                'message' => 'Account is not active',
                'status_code' => 403,
            ];
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'success' => true,
            'user' => $user,
            'token' => $token,
            // 'token_type' => 'Bearer',
            'message' => 'Login successful'
        ];
    }

    public function logout(Request $request): void
    {
        $request->user()->currentAccessToken()->delete();
    }
}
