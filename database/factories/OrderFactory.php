<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'payment_id' => Payment::factory(),
            'total_amount' => fake()->randomFloat(2, 0, 99999999.99),
            'status' => fake()->word(),
        ];
    }
}
