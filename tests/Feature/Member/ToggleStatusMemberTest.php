<?php

namespace Tests\Feature\Member;

use App\Livewire\Admin\Members\ToggleStatusMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ToggleStatusMemberTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function el_componente_prepara_correctamente_los_datos_para_el_modal()
    {

        $member = User::factory()->create([
            'first_name' => 'Ana',
            'last_name' => 'García',
            'status' => 'active'
        ]);

        // 2. Simulamos el evento que dispara la tabla
        Livewire::test(ToggleStatusMember::class)
            ->dispatch('open-status-modal', id: $member->id)
            ->assertSet('selectedMemberId', $member->id)
            ->assertSet('selectedMemberName', 'Ana García')
            ->assertSet('currentStatus', 'active')
            ->assertSet('targetStatus', 'inactive')
            ->assertSet('confirmingStatusChange', true);
    }

    #[Test]
    public function puede_cambiar_el_estado_de_activo_a_inactivo()
    {
        $member = User::factory()->create(['status' => 'active']);

        Livewire::test(ToggleStatusMember::class)
            ->dispatch('open-status-modal', id: $member->id)
            ->call('updateStatus')
            ->assertSet('confirmingStatusChange', false)
            ->assertDispatched('member-updated');

        $this->assertDatabaseHas('users', [
            'id' => $member->id,
            'status' => 'inactive'
        ]);
    }

    #[Test]
    public function puede_cambiar_el_estado_de_pendiente_a_activo()
    {
        $member = User::factory()->create(['status' => 'pending']);

        Livewire::test(ToggleStatusMember::class)
            ->dispatch('open-status-modal', id: $member->id)
            ->assertSet('targetStatus', 'active')
            ->call('updateStatus');

        $this->assertDatabaseHas('users', [
            'id' => $member->id,
            'status' => 'active'
        ]);
    }

    #[Test]
    public function puede_cambiar_el_estado_de_inactivo_a_activo()
    {
        $member = User::factory()->create(['status' => 'inactive']);

        Livewire::test(ToggleStatusMember::class)
            ->dispatch('open-status-modal', id: $member->id)
            ->assertSet('targetStatus', 'active') // Verifica el match
            ->call('updateStatus');

        $this->assertDatabaseHas('users', [
            'id' => $member->id,
            'status' => 'active'
        ]);
    }
}
