<?php

namespace Tests\Feature\Auth;

use App\Livewire\Auth\RecoveryForm;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Mockery\MockInterface;
use Tests\TestCase;

class RecoveryFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_password_recovery_flow_is_successful(): void
    {

        $user = User::factory()->create([
            'email' => 'usuario@example.com',
            'password' => Hash::make('old_password'),
        ]);

        $otpCode = '123456';
        $newPassword = 'NewSecurePassword123!';


        $this->mock(OtpService::class, function (MockInterface $mock) use ($user, $otpCode) {
            $mock->shouldReceive('generate')
                ->with($user->email)
                ->once()
                ->andReturn($otpCode);

            $mock->shouldReceive('send')
                ->with($user->email, $otpCode)
                ->once();

            $mock->shouldReceive('validate')
                ->with($user->email, $otpCode)
                ->once()
                ->andReturn(true);
        });


        Livewire::test(RecoveryForm::class)
            // Paso 1: Enviar Email
            ->set('email', $user->email)
            ->call('sendOtp')
            /*->tap(fn ($component) => dd($component->errors()))*/
            ->assertSet('step', 2)
            ->assertHasNoErrors()

            // Paso 2: Verificar OTP
            ->set('otp', $otpCode)
            ->call('verifyOtp')
            ->assertSet('step', 3)
            ->assertHasNoErrors()

            // Paso 3: Restablecer Contraseña
            ->set('password', $newPassword)
            ->set('password_confirmation', $newPassword)
            ->call('recoveryPassword')
            ->assertRedirect(route('login'))
            ->assertSessionHas('message', 'Contraseña restablecida correctamente.');


        $this->assertTrue(Hash::check($newPassword, $user->fresh()->password));
    }

    public function test_it_fails_when_email_does_not_exist(): void
    {
        Livewire::test(RecoveryForm::class)
            ->set('email', 'noexiste@example.com')
            ->call('sendOtp')
            ->assertHasErrors(['email' => 'Email is invalid, try again'])
            ->assertSet('step', 1);
    }
}
