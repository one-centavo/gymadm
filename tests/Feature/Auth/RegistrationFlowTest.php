<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Auth\RegisterForm;
use App\Services\RegistrationService;
use App\Models\User;

class RegistrationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_access_registration_initial_page(): void
    {
        $this->get('/register')
            ->assertStatus(200)
            ->assertSeeLivewire(RegisterForm::class);
    }

    public function test_email_validation_prevents_advancing_to_otp(): void
    {
        Livewire::test(RegisterForm::class)
            ->set('email', 'correo-invalido')
            ->call('sendOtp')
            ->assertHasErrors(['email'])
            ->assertSet('step', 1);
    }

    public function test_valid_email_advances_to_otp_step(): void
    {
        $this->mock(RegistrationService::class, function ($mock) {
            $mock->shouldReceive('isEmailAvailable')
                ->with('test@example.com')
                ->once()
                ->andReturn(true);

            $mock->shouldReceive('requestEmailVerification')
                ->with('test@example.com')
                ->once();
        });

        Livewire::test(RegisterForm::class)
            ->set('email', 'test@example.com')
            ->call('sendOtp')
            ->assertHasNoErrors()
            ->assertSet('step', 2);
    }

    public function test_otp_validation_prevents_advancing_to_data_form(): void
    {
        Livewire::test(RegisterForm::class)
            ->set('step', 2)
            ->set('email', 'test@example.com')
            ->set('otp', '')
            ->call('verifyOtp')
            ->assertHasErrors(['otp'])
            ->assertSet('step', 2);
    }

    public function test_valid_otp_advances_to_final_registration_form(): void
    {
        $this->mock(RegistrationService::class, function ($mock) {
            $mock->shouldReceive('verifyIdentity')
                ->with('test@example.com', '123456')
                ->once()
                ->andReturn(true);
        });

        Livewire::test(RegisterForm::class)
            ->set('step', 2)
            ->set('email', 'test@example.com')
            ->set('otp', '123456')
            ->call('verifyOtp')
            ->assertHasNoErrors()
            ->assertSet('step', 3);
    }

    public function test_successful_registration_redirects_to_login(): void
    {
        $fakeUser = new User(['id' => 1, 'email' => 'test@example.com']);

        $this->mock(RegistrationService::class, function ($mock) use ($fakeUser) {
            $mock->shouldReceive('checkDocumentUniqueness')
                ->with('CC', '1000222333')
                ->once()
                ->andReturn(true);

            $mock->shouldReceive('registerByMember')
                ->once()
                ->andReturn($fakeUser);
        });

        Livewire::test(RegisterForm::class)
            ->set('step', 3)
            ->set('email', 'test@example.com')
            ->set('first_name', 'Gustavo')
            ->set('last_name', 'Centavo')
            ->set('document_type', 'CC')
            ->set('document_number', '1000222333')
            ->set('phone_number', '3001234567')
            ->set('password', 'GymAdm2026!')
            ->set('password_confirmation', 'GymAdm2026!')
            ->call('registerMember')
            ->assertHasNoErrors()
            ->assertRedirect(route('login'));
    }
}
