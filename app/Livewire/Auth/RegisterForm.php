<?php



namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Services\RegistrationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Exception;

#[Layout('components.layouts.guest')]
class RegisterForm extends Component
{
    public int $step = 1;
    public string $email = '';
    public string $otp = '';
    public string $document_type = '';
    public string $document_number = '';
    public string $name = '';

    protected RegistrationService $registrationService;

    public function boot(RegistrationService $registrationService): void
    {
        $this->registrationService = $registrationService;
    }

    public function sendOtp(): void
    {
        $this->validate(['email' => 'required|email']);

        if (!$this->registrationService->isEmailAvailable($this->email)) {
            $this->addError('email', 'Verify your email and try again.');
            return;
        }

        $this->registrationService->requestEmailVerification($this->email);

        $this->step = 2;
    }

    public function verifyOtp(): void
    {
        $this->validate(['otp' => 'required|numeric']);

        if (!$this->registrationService->verifyIdentity($this->email, $this->otp)) {
            $this->addError('otp', 'Invalid OTP code. Please try again.');
            return;
        }

        $this->step = 3;
    }

    public function registerMember(): Redirector|RedirectResponse|null
    {
        $data = $this->validate([
            'document_type' => 'required',
            'document_number' => 'required',
            'name' => 'required|string|max:255',
        ]);

        if (!$this->registrationService->checkDocumentUniqueness($this->document_type, $this->document_number)) {
            $this->addError('document_number', 'Verify your document information and try again.');
            return null;
        }

        $data['email'] = $this->email;

        try {
            $this->registrationService->registerByMember($data);

            session()->flash('message', 'Registration successful. You can now log in.');
            return redirect()->route('login');

        } catch (Exception $e) {
            Log::error($e->getMessage());
            $this->addError('registration', 'Something went wrong. Please try again.');
            return null;
        }
    }

    public function render(): View
    {
        return view('livewire.auth.register-form');
    }
}
