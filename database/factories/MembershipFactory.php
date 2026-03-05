<?php

namespace Database\Factories;

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
        $plan = \App\Models\MembershipPlan::inRandomOrder()->first()
            ?? \App\Models\MembershipPlan::factory()->create();

        return [
            // 2. Buscamos un usuario al azar que sea el "dueño" de esta membresía
            'user_id' => \App\Models\User::inRandomOrder()->first()?->id ?? \App\Models\User::factory(),

            'memberships_plan_id' => $plan->id,

            // 3. Lógica de fechas usando Carbon
            'start_date' => now(),
            'end_date' => now()->addMonths($plan->duration_value), // Se calcula según el plan

            'status' => 'active',
            'payment_method' => fake()->randomElement(['cash', 'transfer', 'card']),
            'price_paid' => $plan->price, // El precio pagado coincide con el del plan
            'cancellation_reason' => null,
            'cancelled_at' => null,
        ];
    }
}
