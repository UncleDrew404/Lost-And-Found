<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use Spatie\Permission\Models\Role;

class RoleController extends BaseController
{
    public function index()
    {
        $roles = Role::query()
            ->where('guard_name', 'sanctum')
            ->with('permissions:id,name')
            ->orderBy('name')
            ->get()
            ->map(fn (Role $role) => [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $role->permissions->pluck('name')->values(),
            ]);

        return $this->success($roles, 'Roles retrieved successfully');
    }
}
