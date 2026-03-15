<?php

namespace App\Livewire\Auth;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Exception;


#[Layout('components.layouts.guest')]
class LoginForm extends Component
{
    public string $email = '';
    public string $password = '';

    protected AuthService $authService;

    public function boot(AuthService $authService): void
    {
        $this->authService = $authService;
    }

    public function logIn(): void
    {
        $request = new LoginRequest();
        $validatedData = $this->validate($request->rules(), $request->messages());

        $this->email = Str::lower(trim($validatedData['email']));
        $credentials = [
            'email' => $this->email,
            'password' => $validatedData['password'],
        ];

        $throttleKey = $this->throttleKey();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('email', "Demasiados intentos. Intenta nuevamente en {$seconds} segundos.");
            return;
        }

        try{
            if (!$this->authService->login($credentials)) {
                RateLimiter::hit($throttleKey, 60);
                $this->addError('email', 'Correo o contraseña incorrectos.');
                return;
            }

            RateLimiter::clear($throttleKey);
            $this->redirectIntended(default: '/');

        }catch (Exception $e){
            report($e);
            $this->addError('email', 'Ocurrió un error al intentar iniciar sesión. Por favor, inténtalo de nuevo más tarde.');
        }

    }

    protected function throttleKey(): string
    {
        return Str::lower(trim($this->email)) . '|' . request()->ip();
    }

    public function render() : View
    {
        return view('livewire.auth.login-form');
    }
}
