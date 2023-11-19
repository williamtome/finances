<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Revenue>
 */
class RevenueFactory extends Factory
{
    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence,
            'amount' => $this->faker->randomFloat(),
        ];
    }
}
