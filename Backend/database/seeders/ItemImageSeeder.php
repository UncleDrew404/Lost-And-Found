<?php

namespace Database\Seeders;

use App\Models\ItemImage;
use Illuminate\Database\Seeder;

class ItemImageSeeder extends Seeder
{
    public function run(): void
    {
        ItemImage::factory(10)
            ->create();
    }
}
