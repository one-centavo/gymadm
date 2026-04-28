<?php

declare(strict_types=1);

namespace Tests\Feature\Membership;

use App\Livewire\Admin\Memberships\CancelMembership;
use App\Models\Membership;
use App\Models\User;
use App\Services\SubscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Mockery\MockInterface;
use Tests\TestCase;

class CancelMembershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_renders_successfully()
    {
        Livewire::test(CancelMembership::class)
            ->assertStatus(200);
    }

    public function test_admin_can_cancel_membership()
    {
        $user = User::factory()->create(['role' => 'member', 'status' => 'active']);
        $membership = Membership::factory()->create([
            'user_id' => $user->id,
            'status' => 'active',
        ]);
        $reason = 'El usuario solicitó la cancelación por mudanza.';

        $this->mock(SubscriptionService::class, function (MockInterface $mock) use ($membership, $reason) {
            $mock->shouldReceive('cancelMembership')
                ->once()
                ->with($membership->id, $reason)
                ->andReturnNull();
        });

        Livewire::test(CancelMembership::class)
            ->call('openCancelModal', $membership->id)
            ->set('reason', $reason)
            ->call('cancel')
            ->assertHasNoErrors()
            ->assertDispatched('membership.cancelled')
            ->assertDispatched('message', 'La membresía ha sido cancelada correctamente.')
            ->assertSet('openModal', false);
    }

    public function test_validation_errors_are_shown_when_reason_is_missing()
    {
        $user = User::factory()->create(['role' => 'member', 'status' => 'active']);
        $membership = Membership::factory()->create([
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        Livewire::test(CancelMembership::class)
            ->call('openCancelModal', $membership->id)
            ->set('reason', '')
            ->call('cancel')
            ->assertHasErrors(['reason'])
            ->assertNotDispatched('membership.cancelled');
    }
}
