<?php

namespace Database\Factories;

use App\Models\MembershipPlan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Membership>
 */
class MembershipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'            => User::factory(),
            'membership_plan_id' => MembershipPlan::factory(),
            'start_date'         => now()->toDateString(),
            'end_date'           => function (array $attributes) {
                $plan = MembershipPlan::find($attributes['membership_plan_id']);
                return now()->addMonths($plan?->duration_value ?? 1);
            },
            'status'             => 'active',
            'payment_method'     => $this->faker->randomElement(['cash', 'transfer', 'card']),
            'price_paid'         => function (array $attributes) {
                return MembershipPlan::find($attributes['membership_plan_id'])?->price ?? 0;
            },
            'cancellation_reason' => null,
            'cancelled_at'        => null,
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'status'   => 'active',
            'end_date' => now()->addDays(rand(5, 25)),
        ]);
    }

    public function expired(): static
    {
        return $this->state(fn () => [
            'status'     => 'inactive',
            'start_date' => now()->subMonths(2),
            'end_date'   => now()->subDays(rand(1, 10)),
        ]);
    }
}
