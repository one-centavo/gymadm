<?php

declare(strict_types=1);

namespace Tests\Feature\Membership;

use App\Livewire\Membership\AssignMembership;
use App\Models\User;
use App\Models\MembershipPlan;
use App\Models\Membership;
use App\Services\SubscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Mockery\MockInterface;
use Tests\TestCase;

class AssignMembershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_renders_successfully()
    {
        Livewire::test(AssignMembership::class)
            ->assertStatus(200);
    }

    public function test_admin_can_assign_membership_to_member()
    {
        $user = User::factory()->create(['role' => 'member', 'status' => 'active']);
        $plan = MembershipPlan::factory()->active()->create();

        $this->mock(SubscriptionService::class, function (MockInterface $mock) use ($user, $plan) {
            $mock->shouldReceive('assignMembership')->andReturnUsing(function ($dto) use ($user, $plan) {
                return Membership::factory()->create([
                    'user_id' => $user->id,
                    'membership_plan_id' => $plan->id,
                    'payment_method' => 'cash',
                    'start_date' => now()->toDateString(),
                    'end_date' => now()->addMonths($plan->duration_value)->toDateString(),
                    'price_paid' => $plan->price,
                    'status' => 'active',
                ]);
            });
        });

        Livewire::test(AssignMembership::class)
            ->set('userId', $user->id)
            ->set('planId', $plan->id)
            ->set('paymentMethod', 'cash')
            ->set('startDate', now()->toDateString())
            ->call('assign')
            ->assertHasNoErrors()
            ->assertDispatched('membership.assigned')
            ->assertSet('open', false);

        $this->assertDatabaseHas('memberships', [
            'user_id' => $user->id,
            'membership_plan_id' => $plan->id,
            'status' => 'active',
        ]);
    }

    public function test_validation_errors_are_shown_when_required_fields_are_missing()
    {
        Livewire::test(AssignMembership::class)
            ->set('userId', 0)
            ->set('planId', 0)
            ->set('paymentMethod', '')
            ->set('startDate', '')
            ->call('assign')
            ->assertHasErrors(['userId', 'planId', 'paymentMethod', 'startDate'])
            ->assertNotDispatched('membership.assigned');
    }
}
