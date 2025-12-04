<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'provider' => fake()->word(),
            'payment_reference' => fake()->word(),
            'status' => fake()->word(),
            'amount' => fake()->randomFloat(2, 0, 99999999.99),
        ];
    }
}
