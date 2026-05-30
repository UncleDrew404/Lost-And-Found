<?php

namespace Database\Seeders;

use App\Models\Claim;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClaimSeeder extends Seeder
{
    public function run(): void
    {
        $items = Item::all();
        $students = User::role('student', 'sanctum')->get();

        Claim::factory(10)->create([
            'item_id' => $items->random()->id,
            'user_id' => $students->random()->id,
        ]);
    }
}
