<?php

namespace App\Livewire\Auth;

use App\Http\Requests\PasswordRecoveryOtpRequest;
use App\Http\Requests\PasswordRecoveryRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Models\SecurityCode;
use App\Services\PasswordRecoveryService;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use RuntimeException;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Validator;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

#[Layout('components.layouts.guest')]
class RecoveryForm extends Component
{
    #[Url]
    public int $step = 1;
    public int $resendCountdown = 0;
    public string $email = "";
    public string $password = "";
    public string $password_confirmation = "";
    public string $otp = "";

    protected PasswordRecoveryService $passwordRecoveryService;
    public function boot(PasswordRecoveryService $passwordRecoveryService): void
    {
        $this->passwordRecoveryService = $passwordRecoveryService;
    }
    public function sendOtp():void
    {
        $request = new PasswordRecoveryOtpRequest();
        $this->validate($request->rules(), $request->messages());

        try{


            $this->passwordRecoveryService->requestRecovery($this->email);
            $this->step = 2;
            $this->resendCountdown = 60;
        }catch(RuntimeException $e){
            $this->addError('email',$e->getMessage());
        }


    }

    public function resendOtp(): void
    {
        try {
            $this->passwordRecoveryService->requestRecovery($this->email);
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

    public function mount(): void
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

        if (!$this->passwordRecoveryService->validateRecoveryCode($this->email, $this->otp)) {
            $this->addError('otp', 'Código OTP inválido o expirado. Intenta nuevamente.');
            return;
        }


        $this->step = 3;
    }

    public function recoveryPassword(): void
    {
        $request = new PasswordRecoveryRequest();

        $this->validate($request->rules(), $request->messages());

        try {
            $this->passwordRecoveryService->resetPassword($this->email, $this->password);
            session()->flash('message', 'Contraseña restablecida correctamente.');
            $this->redirectRoute('login');
        } catch (ModelNotFoundException $e) {
            logger($e->getMessage());
            $this->addError('email', 'No se encontró el usuario.');
        } catch (ValidationException $e) {
            logger($e->getMessage());
            $this->addError('password', 'La contraseña no cumple con los requisitos.');
        } catch (Exception $e) {
            logger($e->getMessage());
            $this->addError('password', 'Ocurrió un error inesperado. Intenta nuevamente.');
        }
    }

    public function render() : View
    {
        return view('livewire.auth.recovery-form');
    }
}
