<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'event_id' => Event::factory(),
            'ticket_code' => fake()->word(),
            'pdf_path' => fake()->word(),
            'price' => fake()->randomFloat(2, 0, 999999.99),
        ];
    }
}
