<?php

namespace Tests\Feature\Plan;

use App\Livewire\Plan\CreatePlan;
use App\Models\MembershipPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreatePlanTest extends TestCase
{
    use RefreshDatabase;

    public function test_component_renders_correctly()
    {
        Livewire::test(CreatePlan::class)
            ->assertStatus(200)
            ->assertSee('NUEVO PLAN');
    }

    public function test_can_create_a_plan_with_valid_data()
    {
        Livewire::test(CreatePlan::class)
            ->set('name', 'Plan Guerrero')
            ->set('description', 'Acceso total al área de pesas')
            ->set('price', 80000)
            ->set('duration_value', 1)
            ->set('duration_unit', 'months')
            ->call('create')
            ->assertHasNoErrors()
            ->assertDispatched('plan.created');

        $this->assertDatabaseHas('membership_plans', [
            'name' => 'Plan Guerrero',
            'price' => 80000,
            'duration_unit' => 'months'
        ]);
    }

    public function test_does_not_allow_duplicate_names_validating_via_service()
    {
        MembershipPlan::create([
            'name' => 'Plan Existente',
            'description' => 'Test',
            'price' => 50000,
            'duration_value' => 1,
            'duration_unit' => 'months',
            'status' => 'active'
        ]);

        Livewire::test(CreatePlan::class)
            ->set('name', 'Plan Existente')
            ->set('description', 'Acceso total al área de pesas')
            ->set('price', 60000)
            ->set('duration_value', 1)
            ->set('duration_unit', 'months')
            ->call('create')
            // Afirmar simplemente que hay un error en 'name' es suficiente y no fallará por errores tipográficos o traducciones.
            ->assertHasErrors(['name']);
    }

    public function test_validates_required_fields_according_to_request()
    {
        Livewire::test(CreatePlan::class)
            ->set('name', '')
            ->call('create')
            ->assertHasErrors(['name' => 'required']);
    }
}
