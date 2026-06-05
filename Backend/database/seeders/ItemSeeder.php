<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::role(['admin', 'staff'], 'sanctum')->get();
        $categories = Category::all();

        Item::factory(20)->create([
            'user_id' => fn () => $users->random()->id,
            'category_id' => fn () => $categories->random()->id,
        ]);
    }
}
