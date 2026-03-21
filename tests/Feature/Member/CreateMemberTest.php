<?php

namespace Tests\Feature\Member;

use App\Livewire\Member\CreateMember;
use App\Models\User;
use App\Services\OtpService;
use App\Services\RegistrationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Mockery\MockInterface;
use Tests\TestCase;

class CreateMemberTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mock(OtpService::class, function (MockInterface $mock) {
            $mock->shouldReceive('send')->andReturn(true);
        });
    }

    public function test_renders_successfully()
    {
        Livewire::test(CreateMember::class)
            ->assertStatus(200);
    }

    public function test_administrator_can_register_a_new_member()
    {
        $this->mock(RegistrationService::class, function (MockInterface $mock) {
            $mock->shouldReceive('checkDocumentUniqueness')->andReturn(true);
        });

        Livewire::test(CreateMember::class)
            ->set('first_name', 'Juan')
            ->set('last_name', 'Pérez')
            ->set('document_type', 'CC')
            ->set('document_number', '1234567890')
            ->set('phone_number', '3001234567')
            ->set('email', 'juan@example.com')
            ->call('register')
            ->assertHasNoErrors()
            ->assertDispatched('member.registered')
            ->assertSet('open', false);

        $this->assertDatabaseHas('users', [
            'email' => 'juan@example.com',
            'document_number' => '1234567890',
            'role' => 'member',
            'status' => 'pending',
        ]);
    }

    public function test_shows_error_when_document_is_not_unique()
    {
        $this->mock(RegistrationService::class, function (MockInterface $mock) {
            $mock->shouldReceive('checkDocumentUniqueness')->andReturn(false);
        });

        Livewire::test(CreateMember::class)
            ->set('first_name', 'Ana')
            ->set('last_name', 'Gómez')
            ->set('document_type', 'CC')
            ->set('document_number', '987654321')
            ->set('phone_number', '3009876543')
            ->set('email', 'ana@example.com')
            ->call('register')
            ->assertHasErrors(['document_number'])
            ->assertNotDispatched('member.registered');

        $this->assertDatabaseMissing('users', [
            'document_number' => '987654321',
        ]);
    }

    public function test_it_listens_to_open_registration_form_event()
    {
        Livewire::test(CreateMember::class)
            ->set('open', false)
            ->dispatch('open-registration-form-with-document', documento: '1122334455')
            ->assertSet('open', true);
    }
}
