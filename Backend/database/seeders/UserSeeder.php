<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@lostfound.test'],
            [
                'password' => Hash::make('password'),
                'status' => 'active',
            ]
        );

        $admin->syncRoles(['admin']);

        $admin->userProfile()->updateOrCreate(
            ['user_id' => $admin->id],
            [
                'first_name' => 'Admin',
                'middle_name' => null,
                'last_name' => 'Drew',
                'gender' => 'Male',
                'phone_number' => '9025252582',
                'bio' => 'Default administrator account.',
                'avatar' => null,
                'department' => 'Administration',
                'student_id' => null,
            ]
        );


        $staff = User::firstOrCreate(
            ['email' => 'staff@lostfound.test'],
            [
                'password' => Hash::make('password'),
                'status' => 'active',
            ]
        );
        
        $staff->syncRoles(['staff']);

        $staff->userProfile()->updateOrCreate(
            ['user_id' => $staff->id],
            [
                'first_name' => 'Staff',
                'middle_name' => null,
                'last_name' => 'Drew',
                'gender' => 'Male',
                'phone_number' => '9025252583',
                'bio' => 'Default staff account.',
                'avatar' => null,
                'department' => 'Staff',
                'student_id' => null,
            ]
        );

        User::factory(10)
            ->withProfile()
            ->create()
            ->each(fn(User $user) => $user->assignRole('student'));
    }
}
