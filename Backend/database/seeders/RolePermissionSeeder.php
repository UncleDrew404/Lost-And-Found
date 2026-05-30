<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guard = 'sanctum';
        $permissions = [
            'items.view',
            'items.manage',
            'categories.manage',
            'claims.moderate',
            'users.view',
            'users.manage',
            'roles.view',
            'roles.assign',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, $guard);
        }

        Role::findOrCreate('student', $guard)
            ->syncPermissions(['items.view']);

        Role::findOrCreate('staff', $guard)
            ->syncPermissions([
                'items.view',
                'items.manage',
                'categories.manage',
                'claims.moderate',
            ]);

        Role::findOrCreate('admin', $guard)
            ->syncPermissions($permissions);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
