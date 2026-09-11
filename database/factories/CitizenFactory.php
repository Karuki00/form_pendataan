<?php

namespace Database\Factories;

use App\Models\Citizen;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Citizen>
 */
class CitizenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => fake()->unique()->numerify('################'),
            'name' => fake()->name(),
            'wife_name' => fake()->optional()->name(),
            'house_number' => fake()->numerify('##'),
            'marital_status' => fake()->randomElement(['single', 'married', 'divorced', 'widowed']),
            'children_count' => fake()->numberBetween(0, 5),
            'monthly_income' => fake()->numberBetween(0, 15000000),
            'income_range' => '0_3jt',
            'financial_status' => fake()->randomElement(['low_income', 'middle_income', 'high_income']),
            'status' => 'active',
        ];
    }
}
