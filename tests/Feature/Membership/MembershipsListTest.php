<?php

declare(strict_types=1);

namespace Tests\Feature\Membership;

use App\Livewire\Membership\MembershipsList;
use App\Models\User;
use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Services\SubscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class MembershipsListTest extends TestCase
{
    use RefreshDatabase;

    protected SubscriptionService $subscriptionService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subscriptionService = app(SubscriptionService::class);
    }

    #[Test]
    public function getPlanList_returns_paginator(): void
    {
        $plan = MembershipPlan::factory()->create();
        $user = User::factory()->create();
        Membership::factory()->create([
            'user_id' => $user->id,
            'membership_plan_id' => $plan->id,
        ]);

        $result = $this->subscriptionService->getPlanList();
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $result);
        $this->assertEquals(1, $result->total());
    }

    #[Test]
    public function getPlanList_filters_by_search(): void
    {
        $plan = MembershipPlan::factory()->create();
        $user1 = User::factory()->create(['first_name' => 'Juan']);
        $user2 = User::factory()->create(['first_name' => 'Pedro']);
        Membership::factory()->create(['user_id' => $user1->id, 'membership_plan_id' => $plan->id]);
        Membership::factory()->create(['user_id' => $user2->id, 'membership_plan_id' => $plan->id]);

        $result = $this->subscriptionService->getPlanList('Juan');
        $this->assertEquals(1, $result->total());
        $this->assertEquals('Juan', $result->items()[0]->first_name);
    }

    #[Test]
    public function getPlanList_filters_by_status(): void
    {
        $plan = MembershipPlan::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Membership::factory()->create(['user_id' => $user1->id, 'membership_plan_id' => $plan->id, 'status' => 'active', 'end_date' => now()->addDays(10)]);
        Membership::factory()->create(['user_id' => $user2->id, 'membership_plan_id' => $plan->id, 'status' => 'canceled', 'end_date' => now()->addDays(10)]);

        $result = $this->subscriptionService->getPlanList('', 'vigente');
        $this->assertEquals(1, $result->total());
        $this->assertEquals('active', $result->items()[0]->membership_status);
    }

    #[Test]
    public function getPlanList_paginates_correctly(): void
    {
        $plan = MembershipPlan::factory()->create();
        User::factory(12)->create()->each(function ($user) use ($plan) {
            Membership::factory()->create(['user_id' => $user->id, 'membership_plan_id' => $plan->id]);
        });
        $result = $this->subscriptionService->getPlanList();
        $this->assertCount(10, $result->items());
        $this->assertEquals(2, $result->lastPage());
    }

    #[Test]
    public function component_renders(): void
    {
        $plan = MembershipPlan::factory()->create();
        $user = User::factory()->create();
        Membership::factory()->create(['user_id' => $user->id, 'membership_plan_id' => $plan->id]);
        Livewire::test(MembershipsList::class)->assertStatus(200);
    }

    #[Test]
    public function component_displays_memberships(): void
    {
        $plan = MembershipPlan::factory()->create();
        $user = User::factory()->create();
        Membership::factory()->create(['user_id' => $user->id, 'membership_plan_id' => $plan->id]);
        Livewire::test(MembershipsList::class)
            ->assertViewHas('memberships', function ($result) {
                return $result->total() === 1;
            });
    }

    #[Test]
    public function component_search_filters_memberships(): void
    {
        $plan = MembershipPlan::factory()->create();
        $user1 = User::factory()->create(['first_name' => 'Ana']);
        $user2 = User::factory()->create(['first_name' => 'Luis']);
        Membership::factory()->create(['user_id' => $user1->id, 'membership_plan_id' => $plan->id]);
        Membership::factory()->create(['user_id' => $user2->id, 'membership_plan_id' => $plan->id]);
        Livewire::test(MembershipsList::class)
            ->set('search', 'Ana')
            ->assertViewHas('memberships', function ($result) {
                return $result->total() === 1;
            });
    }

    #[Test]
    public function component_status_filter_works(): void
    {
        $plan = MembershipPlan::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Membership::factory()->create(['user_id' => $user1->id, 'membership_plan_id' => $plan->id, 'status' => 'active', 'end_date' => now()->addDays(10)]);
        Membership::factory()->create(['user_id' => $user2->id, 'membership_plan_id' => $plan->id, 'status' => 'canceled', 'end_date' => now()->addDays(10)]);
        Livewire::test(MembershipsList::class)
            ->set('statusFilter', 'cancelado')
            ->assertViewHas('memberships', function ($result) {
                return $result->total() === 1 && $result->items()[0]->membership_status === 'canceled';
            });
    }

    #[Test]
    public function component_setFilter_updates_status(): void
    {
        $plan = MembershipPlan::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Membership::factory()->create(['user_id' => $user1->id, 'membership_plan_id' => $plan->id, 'status' => 'active', 'end_date' => now()->addDays(10)]);
        Membership::factory()->create(['user_id' => $user2->id, 'membership_plan_id' => $plan->id, 'status' => 'canceled', 'end_date' => now()->addDays(10)]);
        Livewire::test(MembershipsList::class)
            ->call('setFilter', 'vigente')
            ->assertViewHas('memberships', function ($result) {
                return $result->total() === 1 && $result->items()[0]->membership_status === 'active';
            });
    }

    #[Test]
    public function component_setFilter_resets_pagination(): void
    {
        $plan = MembershipPlan::factory()->create();
        User::factory(15)->create()->each(function ($user) use ($plan) {
            Membership::factory()->create(['user_id' => $user->id, 'membership_plan_id' => $plan->id, 'status' => 'active', 'end_date' => now()->addDays(10)]);
        });
        User::factory(15)->create()->each(function ($user) use ($plan) {
            Membership::factory()->create(['user_id' => $user->id, 'membership_plan_id' => $plan->id, 'status' => 'canceled', 'end_date' => now()->addDays(10)]);
        });
        Livewire::test(MembershipsList::class)
            ->call('setFilter', 'vigente')
            ->assertViewHas('memberships', function ($result) {
                return $result->total() === 15;
            });
    }

    #[Test]
    public function component_default_filter_is_all(): void
    {
        $plan = MembershipPlan::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Membership::factory()->create(['user_id' => $user1->id, 'membership_plan_id' => $plan->id]);
        Membership::factory()->create(['user_id' => $user2->id, 'membership_plan_id' => $plan->id]);
        Livewire::test(MembershipsList::class)
            ->assertSet('statusFilter', 'all')
            ->assertViewHas('memberships', function ($result) {
                return $result->total() === 2;
            });
    }

    #[Test]
    public function component_reactive_search(): void
    {
        $plan = MembershipPlan::factory()->create();
        User::factory(5)->create()->each(function ($user) use ($plan) {
            Membership::factory()->create(['user_id' => $user->id, 'membership_plan_id' => $plan->id]);
        });
        Livewire::test(MembershipsList::class)
            ->set('search', 'NonExistent')
            ->assertViewHas('memberships', function ($result) {
                return $result->total() === 0;
            });
    }
}
