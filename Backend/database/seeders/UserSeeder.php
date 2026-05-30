<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@lostfound.test'],
            [
                'password' => Hash::make('password'),
                'status' => 'active',
            ]
        )->syncRoles(['admin']);

        User::firstOrCreate(
            ['email' => 'staff@lostfound.test'],
            [
                'password' => Hash::make('password'),
                'status' => 'active',
            ]
        )->syncRoles(['staff']);

        User::factory(10)
            ->withProfile()
            ->create()
            ->each(fn (User $user) => $user->assignRole('student'));
    }
}
