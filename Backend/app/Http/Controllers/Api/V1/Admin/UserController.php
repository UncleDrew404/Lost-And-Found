<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;

class UserController extends BaseController
{
    public function index()
    {
        $users = User::with(['userProfile', 'roles'])->get();

        return $this->success(UserResource::collection($users), 'Users retrieved successfully');
    }

    public function updateRole(UpdateUserRoleRequest $request, User $user)
    {
        $user->syncRoles([$request->validated('role')]);
        $user->load(['userProfile', 'roles.permissions']);

        return $this->success(new UserResource($user), 'User role updated successfully');
    }
}
