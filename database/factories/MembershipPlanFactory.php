<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MembershipPlan>
 */
class MembershipPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->jobTitle() . ' ' . fake()->word() . ' Plan',
            'description' => fake()->sentence(10),
            'price' => fake()->randomElement([50000, 100000, 150000]),
            'duration_value' => fake()->numberBetween(1, 12),
            'duration_unit' => 'months',
            'status' => 'active',
        ];
    }
}
