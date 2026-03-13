<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Services\RegistrationService;
use App\Http\Requests\SendOtpRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use RuntimeException;
use Exception;

#[Layout('components.layouts.guest')]
class RegisterForm extends Component
{
    public int $step = 1;

    public string $email = '';
    public string $otp = '';
    public string $first_name = '';
    public string $middle_name = '';
    public string $last_name = '';
    public string $second_last_name = '';
    public string $document_type = '';
    public string $document_number = '';
    public string $phone_number = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected RegistrationService $registrationService;

    public function boot(RegistrationService $registrationService): void
    {
        $this->registrationService = $registrationService;
    }

    public function sendOtp(): void
    {
        $request = new SendOtpRequest();
        $this->validate($request->rules(), $request->messages());

        if (!$this->registrationService->isEmailAvailable($this->email)) {
            $this->addError('email', 'Este correo ya está registrado.');
            return;
        }

        try {
            $this->registrationService->requestEmailVerification($this->email);
            $this->step = 2;
        } catch (RuntimeException $e) {
            $this->addError('email', $e->getMessage());
        }
    }

    public function verifyOtp(): void
    {
        $request = new VerifyOtpRequest();
        $this->validate($request->rules(), $request->messages());

        if (!$this->registrationService->verifyIdentity($this->email, $this->otp)) {
            $this->addError('otp', 'Código OTP inválido o expirado. Intenta nuevamente.');
            return;
        }

        $this->step = 3;
    }

    public function registerMember(): mixed
    {
        $request = new RegisterRequest();
        $validatedData = $this->validate($request->rules());

        if (!$this->registrationService->checkDocumentUniqueness($this->document_type, $this->document_number)) {
            $this->addError('document_number', 'Este documento ya se encuentra registrado en el sistema.');
            return null;
        }

        $validatedData['email'] = $this->email;

        try {
            $this->registrationService->registerByMember($validatedData);

            session()->flash('message', '¡Registro exitoso! Ya puedes iniciar sesión en tu gimnasio.');

            return redirect()->route('login');

        } catch (Exception $e) {
            Log::error('Error en registro de GYMADM: ' . $e->getMessage());
            $this->addError('registration', 'Ocurrió un error inesperado. Por favor, intenta de nuevo.');
            return null;
        }
    }

    public function render(): View
    {
        return view('livewire.auth.register-form');
    }
}
