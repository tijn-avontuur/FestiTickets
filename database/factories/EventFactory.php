<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'location' => fake()->word(),
            'date' => fake()->dateTime(),
            'total_tickets' => fake()->numberBetween(-10000, 10000),
            'price' => fake()->randomFloat(2, 0, 999999.99),
            'image_url' => fake()->word(),
        ];
    }
}
