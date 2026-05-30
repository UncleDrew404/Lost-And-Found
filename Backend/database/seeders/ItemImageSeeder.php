<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Database\Seeder;

class ItemImageSeeder extends Seeder
{
    public function run(): void
    {
        $items = Item::all();

        ItemImage::factory(10)->create([
            'item_id' => $items->random()->id,
        ]);
    }
}
