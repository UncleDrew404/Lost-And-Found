<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => fake()->name(),
            'middle_name' => fake()->optional(0.5)->name(),
            'last_name' => fake()->name(),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'phone_number' => fake()->phoneNumber(),
            'bio' => fake()->optional(0.7)->sentence(10),
            'avatar' => null,
            'department' => fake()->randomElement(['Computer Science', 'Engineering', 'Business', 'Arts', 'Science', 'Education']),
            'student_id' => fake()->unique()->numerify('STU-#####'),
        ];
    }
}
