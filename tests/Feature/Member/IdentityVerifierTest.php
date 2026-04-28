<?php

namespace Tests\Feature\Member;

use App\Livewire\Admin\Members\IdentityVerifier;
use App\Models\User;
use App\Services\MemberService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Mockery\MockInterface;
use Tests\TestCase;

class IdentityVerifierTest extends TestCase
{
    use RefreshDatabase;

    public function test_redirects_to_manage_if_member_exists()
    {
        $user = User::factory()->create(['document_number' => '12345']);

        $this->mock(MemberService::class, function (MockInterface $mock) use ($user) {
            $mock->shouldReceive('verifyByDocumentNumber')
                ->with('12345')
                ->andReturn($user);
        });

        Livewire::test(IdentityVerifier::class)
            ->set('document_number', '12345')
            ->call('processIdentification')
            ->assertRedirect(route('memberships.manage', $user));
    }

    public function test_dispatches_event_if_member_does_not_exist()
    {
        $this->mock(MemberService::class, function (MockInterface $mock) {
            $mock->shouldReceive('verifyByDocumentNumber')
                ->andReturn(null);
        });

        Livewire::test(IdentityVerifier::class)
            ->set('document_number', '99999')
            ->call('processIdentification')
            ->assertDispatched('prefix-registration-form', documento: '99999');
    }
}
