<?php

namespace App\Livewire\Member;

use App\Http\Requests\User\RegisterRequest;
use App\Services\MemberService;
use App\Services\RegistrationService;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CreateMember extends Component
{

    public bool $open = false;

    public string $first_name = '';
    public string $middle_name = '';
    public string $last_name = '';
    public string $second_last_name = '';
    public string $document_type = '';
    public string $document_number = '';
    public string $phone_number = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected MemberService $memberService;
    protected RegistrationService $registrationService;

    public function boot(MemberService $memberService, RegistrationService $registrationService): void
    {
        $this->memberService = $memberService;
        $this->registrationService = $registrationService;
    }


    protected $listeners = [
        'open-registration-form-with-document' => 'openRegisterFormWithDocument',
    ];

    public function openRegisterFormWithDocument(): void
    {
        $this->open = true;
        $this->document_number = $this->document_number ?? '';
    }

    public function register(): void
    {
        $request = new RegisterRequest();
        $validatedData = $this->validate(
            $request->rules(true,false),
            $request->messages(),
            $request->attributes()
        );

        if (!$this->registrationService->checkDocumentUniqueness($this->document_type, $this->document_number)) {
            $this->addError('document_number', 'Este documento ya se encuentra registrado en el sistema.');
            return;
        }

        try {
            $this->memberService->registerMember($validatedData);
            session()->flash('message', 'Miembro registrado exitosamente.');
            $this->dispatch('member.registered');
            $this->resetExcept('open');
            $this->open = false;
            return;
        } catch (Exception $e) {
            Log::error('Error en registro de GYMADM: ' . $e->getMessage());
            $this->addError('registration', 'Ocurrió un error inesperado. Por favor, intenta de nuevo.');
        }

    }


}
