<?php

namespace Database\Seeders;

use App\Models\Claim;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClaimSeeder extends Seeder
{
    public function run(): void
    {
        Claim::factory(10)
            ->create();
    }
}
