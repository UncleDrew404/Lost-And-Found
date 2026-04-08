<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'type' => fake()->randomElement(['lost', 'found']),
            'status' => fake()->randomElement(['active', 'resolved']),
            'location' => fake()->address(),
            'date_occured' => fake()->dateTimeBetween('-1 year', 'now'),
            'contact_info' => fake()->phoneNumber(),
        ];
    }
}
