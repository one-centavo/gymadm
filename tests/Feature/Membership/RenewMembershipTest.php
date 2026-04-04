<?php

declare(strict_types=1);

namespace Tests\Feature\Membership;

use App\Livewire\Membership\RenewMembership;
use App\Models\User;
use App\Models\MembershipPlan;
use App\Models\Membership;
use App\Services\SubscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Mockery\MockInterface;
use Tests\TestCase;

class RenewMembershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_renders_successfully()
    {
        Livewire::test(RenewMembership::class)
            ->assertStatus(200);
    }

    public function test_admin_can_renew_membership_for_member()
    {
        $user = User::factory()->create(['role' => 'member', 'status' => 'active']);
        $plan = MembershipPlan::factory()->active()->create();
        $membership = Membership::factory()->create([
            'user_id' => $user->id,
            'membership_plan_id' => $plan->id,
            'payment_method' => 'cash',
            'start_date' => now()->subMonth()->toDateString(),
            'end_date' => now()->toDateString(),
            'price_paid' => $plan->price,
            'status' => 'active',
        ]);

        $this->mock(SubscriptionService::class, function (MockInterface $mock) use ($user, $plan, $membership) {
            $mock->shouldReceive('getLatestMembership')->andReturn($membership);
            $mock->shouldReceive('getSuggestedMembershipDates')->andReturn([
                'start_date' => now()->addDay(),
                'end_date' => now()->addMonth(),
            ]);
            $mock->shouldReceive('assignMembership')->andReturnUsing(function ($dto) use ($user, $plan) {
                return Membership::factory()->create([
                    'user_id' => $user->id,
                    'membership_plan_id' => $plan->id,
                    'payment_method' => 'cash',
                    'start_date' => now()->addDay()->toDateString(),
                    'end_date' => now()->addMonth()->toDateString(),
                    'price_paid' => $plan->price,
                    'status' => 'active',
                ]);
            });
        });

        Livewire::test(RenewMembership::class)
            ->call('openRenewForm', $user->id, app(SubscriptionService::class), app('App\\Services\\PlanService'))
            ->set('planId', $plan->id)
            ->set('paymentMethod', 'cash')
            ->set('startDate', now()->addDay()->toDateString())
            ->call('renew')
            ->assertHasNoErrors()
            ->assertDispatched('membership.renewed')
            ->assertSet('open', false);

        $this->assertDatabaseHas('memberships', [
            'user_id' => $user->id,
            'membership_plan_id' => $plan->id,
            'status' => 'active',
        ]);
    }

    public function test_validation_errors_are_shown_when_required_fields_are_missing()
    {
        Livewire::test(RenewMembership::class)
            ->set('userId', 0)
            ->set('planId', 0)
            ->set('paymentMethod', '')
            ->set('startDate', '')
            ->call('renew')
            ->assertHasErrors(['userId', 'planId', 'paymentMethod', 'startDate'])
            ->assertNotDispatched('membership.renewed');
    }
}
