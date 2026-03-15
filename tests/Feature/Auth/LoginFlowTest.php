<?php

namespace Tests\Feature\Auth;

use App\Livewire\Auth\LoginForm;
use App\Services\AuthService;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Tests\TestCase;

class LoginFlowTest extends TestCase
{
    protected function tearDown(): void
    {
        RateLimiter::clear($this->throttleKey('test@example.com'));
        parent::tearDown();
    }

    public function test_can_access_login_page(): void
    {
        $this->get(route('login'))
            ->assertStatus(200)
            ->assertSeeLivewire(LoginForm::class);
    }

    public function test_dashboard_route_requires_authentication(): void
    {
        $this->get(route('dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_invalid_credentials_show_error_message(): void
    {
        $this->mock(AuthService::class, function ($mock) {
            $mock->shouldReceive('login')
                ->once()
                ->andReturn(false);
        });

        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'wrong-password')
            ->call('logIn')
            ->assertHasErrors(['email']);
    }

    public function test_rate_limit_blocks_after_max_attempts(): void
    {
        $this->mock(AuthService::class, function ($mock) {
            $mock->shouldReceive('login')
                ->times(5)
                ->andReturn(false);
        });

        for ($i = 0; $i < 5; $i++) {
            Livewire::test(LoginForm::class)
                ->set('email', 'test@example.com')
                ->set('password', 'wrong-password')
                ->call('logIn')
                ->assertHasErrors(['email']);
        }

        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'wrong-password')
            ->call('logIn')
            ->assertHasErrors(['email'])
            ->assertSee('Demasiados intentos.');
    }

    public function test_successful_login_redirects_to_intended_destination(): void
    {
        $this->mock(AuthService::class, function ($mock) {
            $mock->shouldReceive('login')
                ->once()
                ->andReturn(true);
        });

        $this->withSession([
            'url.intended' => route('dashboard'),
        ]);

        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'GymAdm2026!')
            ->call('logIn')
            ->assertHasNoErrors()
            ->assertRedirect(route('dashboard'));
    }

    private function throttleKey(string $email, string $ip = '127.0.0.1'): string
    {
        return strtolower(trim($email)) . '|' . $ip;
    }
}

