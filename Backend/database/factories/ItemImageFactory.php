<?php

namespace Database\Factories;

use App\Models\ItemImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ItemImage>
 */
class ItemImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_id' => \App\Models\Item::factory(),
            'image_path' => fake()->imageUrl(),
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }
}
