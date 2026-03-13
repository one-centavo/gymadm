<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Services\RegistrationService;
use App\Models\SecurityCode;
use App\Http\Requests\SendOtpRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Url;
use RuntimeException;
use Exception;

#[Layout('components.layouts.guest')]
class RegisterForm extends Component
{
    #[Url]
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

    public int $resendCountdown = 0;

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
            $this->resendCountdown = 60; // <-- ¡ESTA ES LA CLAVE! Iniciamos el reloj
        } catch (RuntimeException $e) {
            $this->addError('email', $e->getMessage());
        }
    }

    public function resendOtp(): void
    {
        try {
            $this->registrationService->requestEmailVerification($this->email);
            session()->flash('message', 'Código reenviado con éxito.');

            $this->resendCountdown = 60;


            $this->dispatch('reloj-reiniciado');

        } catch (RuntimeException $e) {
            $this->addError('otp', $e->getMessage());
        }
    }

    public function updateCountdown(): void
    {

        $lastCode = SecurityCode::where('email', $this->email)
            ->latest()
            ->first();

        if ($lastCode) {
            $expiry = $lastCode->created_at->addMinute();
            $this->resendCountdown = now()->lessThan($expiry)
                ? now()->diffInSeconds($expiry)
                : 0;
        }
    }

    public function mount() : void
    {
        if ($this->step === 2) {

            $lastCode = SecurityCode::where('email', $this->email)->latest()->first();

            if ($lastCode && $lastCode->created_at->addMinute()->isFuture()) {
                $this->resendCountdown = now()->diffInSeconds($lastCode->created_at->addMinute());
            } else {
                $this->resendCountdown = 0;
            }
        }
    }

    public function verifyOtp(): void
    {
        $this->validate([
            'otp' => (new VerifyOtpRequest())->rules()['otp'],
        ], (new VerifyOtpRequest())->messages());

        if (!$this->registrationService->verifyIdentity($this->email, $this->otp)) {
            $this->addError('otp', 'Código OTP inválido o expirado. Intenta nuevamente.');
            return;
        }


        $this->step = 3;
    }

    public function registerMember(): ?RedirectResponse
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

    public function render(): view
    {
        return view('livewire.auth.register-form');
    }
}
