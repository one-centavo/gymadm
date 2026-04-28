<?php

declare(strict_types=1);

namespace Tests\Feature\Plan;

use App\Livewire\Admin\Plans\PlansList;
use App\Models\MembershipPlan;
use App\Services\PlanService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PlansListTest extends TestCase
{
    use RefreshDatabase;

    protected PlanService $planService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->planService = app(PlanService::class);
    }

    #[Test]
    public function getPlanStats_returns_correct_keys(): void
    {
        MembershipPlan::factory(3)->create(['status' => 'active']);

        $stats = $this->planService->getPlanStats();

        $this->assertArrayHasKey('total', $stats);
        $this->assertArrayHasKey('active', $stats);
        $this->assertArrayHasKey('inactive', $stats);
    }

    #[Test]
    public function getPlanStats_total_count_is_correct(): void
    {
        MembershipPlan::factory(5)->create(['status' => 'active']);
        MembershipPlan::factory(3)->create(['status' => 'inactive']);

        $stats = $this->planService->getPlanStats();

        $this->assertEquals(8, $stats['total']);
    }

    #[Test]
    public function getPlanStats_active_count_is_correct(): void
    {
        MembershipPlan::factory(5)->create(['status' => 'active']);
        MembershipPlan::factory(3)->create(['status' => 'inactive']);

        $stats = $this->planService->getPlanStats();

        $this->assertEquals(5, $stats['active']);
    }

    #[Test]
    public function getPlanStats_inactive_count_is_correct(): void
    {
        MembershipPlan::factory(5)->create(['status' => 'active']);
        MembershipPlan::factory(3)->create(['status' => 'inactive']);

        $stats = $this->planService->getPlanStats();

        $this->assertEquals(3, $stats['inactive']);
    }

    #[Test]
    public function getPlanStats_returns_zeros_when_no_plans(): void
    {
        $stats = $this->planService->getPlanStats();

        $this->assertEquals(0, $stats['total']);
        $this->assertEquals(0, $stats['active']);
        $this->assertEquals(0, $stats['inactive']);
    }

    #[Test]
    public function getPlanList_returns_paginator(): void
    {
        MembershipPlan::factory(5)->create();

        $result = $this->planService->getPlanList();

        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $result);
        $this->assertEquals(5, $result->total());
    }

    #[Test]
    public function getPlanList_paginates_correctly(): void
    {
        MembershipPlan::factory(15)->create();

        $result = $this->planService->getPlanList();

        $this->assertCount(10, $result->items());
        $this->assertEquals(2, $result->lastPage());
    }

    #[Test]
    public function getPlanList_orders_by_latest(): void
    {
        MembershipPlan::factory()->create(['name' => 'Plan Zebra']);
        MembershipPlan::factory()->create(['name' => 'Plan Apple']);

        $result = $this->planService->getPlanList();
        $items = $result->items();

        $this->assertEquals('Plan Zebra', $items[0]->name);
        $this->assertEquals('Plan Apple', $items[1]->name);
    }

    #[Test]
    public function getPlanList_filters_by_name_search(): void
    {
        MembershipPlan::factory()->create(['name' => 'Plan Premium']);
        MembershipPlan::factory()->create(['name' => 'Plan Basic']);
        MembershipPlan::factory()->create(['name' => 'Plan Gold']);

        $result = $this->planService->getPlanList(search: 'Premium');

        $this->assertEquals(1, $result->total());
        $this->assertEquals('Plan Premium', $result->items()[0]->name);
    }

    #[Test]
    public function getPlanList_search_is_case_insensitive(): void
    {
        MembershipPlan::factory()->create(['name' => 'Plan Premium']);
        MembershipPlan::factory()->create(['name' => 'Plan Basic']);

        $result = $this->planService->getPlanList(search: 'premium');

        $this->assertEquals(1, $result->total());
    }

    #[Test]
    public function getPlanList_filters_by_active_status(): void
    {
        MembershipPlan::factory(3)->create(['status' => 'active']);
        MembershipPlan::factory(2)->create(['status' => 'inactive']);

        $result = $this->planService->getPlanList(statusFilter: 'active');

        $this->assertEquals(3, $result->total());
    }

    #[Test]
    public function getPlanList_filters_by_inactive_status(): void
    {
        MembershipPlan::factory(3)->create(['status' => 'active']);
        MembershipPlan::factory(2)->create(['status' => 'inactive']);

        $result = $this->planService->getPlanList(statusFilter: 'inactive');

        $this->assertEquals(2, $result->total());
    }

    #[Test]
    public function getPlanList_filter_all_returns_all_plans(): void
    {
        MembershipPlan::factory(3)->create(['status' => 'active']);
        MembershipPlan::factory(2)->create(['status' => 'inactive']);

        $result = $this->planService->getPlanList(statusFilter: 'all');

        $this->assertEquals(5, $result->total());
    }

    #[Test]
    public function getPlanList_ignores_invalid_status_filter(): void
    {
        MembershipPlan::factory(3)->create(['status' => 'active']);
        MembershipPlan::factory(2)->create(['status' => 'inactive']);

        $result = $this->planService->getPlanList(statusFilter: 'pending');

        $this->assertEquals(5, $result->total());
    }

    #[Test]
    public function getPlanList_combines_search_and_status_filter(): void
    {
        MembershipPlan::factory()->sequence(
            ['name' => 'Plan Premium Alpha', 'status' => 'active'],
            ['name' => 'Plan Premium Beta', 'status' => 'inactive'],
            ['name' => 'Plan Basic Gold', 'status' => 'active']
        )->create();

        $result = $this->planService->getPlanList(search: 'Premium', statusFilter: 'active');

        $this->assertEquals(1, $result->total());
        $this->assertEquals('Plan Premium Alpha', $result->items()[0]->name);
        $this->assertEquals('active', $result->items()[0]->status);
    }

    #[Test]
    public function component_renders(): void
    {
        MembershipPlan::factory(3)->create();

        Livewire::test(PlansList::class)->assertStatus(200);
    }

    #[Test]
    public function component_displays_stats(): void
    {
        MembershipPlan::factory(5)->create(['status' => 'active']);
        MembershipPlan::factory(2)->create(['status' => 'inactive']);

        Livewire::test(PlansList::class)
            ->assertViewHas('stats', function ($stats) {
                return $stats['total'] === 7
                    && $stats['active'] === 5
                    && $stats['inactive'] === 2;
            });
    }

    #[Test]
    public function component_displays_plans(): void
    {
        MembershipPlan::factory(3)->create();

        Livewire::test(PlansList::class)
            ->assertViewHas('plans', function ($result) {
                return $result->total() === 3;
            });
    }

    #[Test]
    public function component_search_filters_plans(): void
    {
        MembershipPlan::factory()->create(['name' => 'Plan Premium']);
        MembershipPlan::factory()->create(['name' => 'Plan Basic']);

        Livewire::test(PlansList::class)
            ->set('search', 'Premium')
            ->assertViewHas('plans', function ($result) {
                return $result->total() === 1;
            });
    }

    #[Test]
    public function component_status_filter_works(): void
    {
        MembershipPlan::factory(3)->create(['status' => 'active']);
        MembershipPlan::factory(2)->create(['status' => 'inactive']);

        Livewire::test(PlansList::class)
            ->set('statusFilter', 'active')
            ->assertViewHas('plans', function ($result) {
                return $result->total() === 3;
            });
    }

    #[Test]
    public function component_setFilter_updates_status(): void
    {
        MembershipPlan::factory(3)->create(['status' => 'active']);
        MembershipPlan::factory(2)->create(['status' => 'inactive']);

        Livewire::test(PlansList::class)
            ->call('setFilter', 'inactive')
            ->assertViewHas('plans', function ($result) {
                return $result->total() === 2;
            });
    }

    #[Test]
    public function component_setFilter_resets_pagination(): void
    {
        MembershipPlan::factory(15)->create(['status' => 'active']);
        MembershipPlan::factory(15)->create(['status' => 'inactive']);

        Livewire::test(PlansList::class)
            ->call('setFilter', 'active')
            ->assertViewHas('plans', function ($result) {
                return $result->total() === 15;
            });
    }

    #[Test]
    public function component_search_and_filter_combined(): void
    {
        MembershipPlan::factory()->sequence(
            ['name' => 'Plan Premium', 'status' => 'active'],
            ['name' => 'Plan Premium Inactive', 'status' => 'inactive'],
            ['name' => 'Plan Basic', 'status' => 'active']
        )->create();

        Livewire::test(PlansList::class)
            ->set('search', 'Premium')
            ->set('statusFilter', 'active')
            ->assertViewHas('plans', function ($result) {
                return $result->total() === 1;
            });
    }

    #[Test]
    public function component_default_filter_is_all(): void
    {
        MembershipPlan::factory(3)->create(['status' => 'active']);
        MembershipPlan::factory(2)->create(['status' => 'inactive']);

        Livewire::test(PlansList::class)
            ->assertSet('statusFilter', 'all')
            ->assertViewHas('plans', function ($result) {
                return $result->total() === 5;
            });
    }

    #[Test]
    public function component_reactive_search(): void
    {
        MembershipPlan::factory(5)->create();

        Livewire::test(PlansList::class)
            ->set('search', 'NonExistent')
            ->assertViewHas('plans', function ($result) {
                return $result->total() === 0;
            });
    }
}
