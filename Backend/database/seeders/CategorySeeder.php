<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    // use WithoutModelEvents;
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics',       'type' => 'electronics'],
            ['name' => 'Personal Items',    'type' => 'personal_items'],
            ['name' => 'Documents',         'type' => 'documents'],
            ['name' => 'Clothing',          'type' => 'clothing'],
            ['name' => 'Bags & Wallets',    'type' => 'bags_wallets'],
            ['name' => 'Keys',              'type' => 'keys'],
            ['name' => 'Books & Stationery', 'type' => 'books_stationery'],
            ['name' => 'Sports Equipment',  'type' => 'sports_equipment'],
            ['name' => 'Jewelry',           'type' => 'jewelry'],
            ['name' => 'Other',             'type' => 'other'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['type' => $cat['type']], $cat);
        }
    }
}
