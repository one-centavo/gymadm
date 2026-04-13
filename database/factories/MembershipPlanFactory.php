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
        $names = ['Bronce', 'Plata', 'Oro', 'Premium', 'VIP', 'Black'];
        return [
            'name'           => 'Plan ' . $this->faker->unique()->randomElement($names),
            'description'    => $this->faker->sentence(10),
            'price'          => $this->faker->randomElement([50000, 80000, 120000, 150000]),
            'duration_value' => $this->faker->randomElement([1, 3, 6, 12]),
            'duration_unit'  => 'months',
            'status'         => 'active',
        ];
    }

    /**
     * Estado activo
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Estado inactivo
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
