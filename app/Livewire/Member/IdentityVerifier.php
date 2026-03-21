<?php

namespace App\Livewire\Member;

use App\Services\MemberService;
use Livewire\Component;

class IdentityVerifier extends Component
{
    public string $document_number = "";

    protected MemberService $memberService;

    public function boot(MemberService $memberService) : Void
    {
        $this->memberService = $memberService;
    }
    public function processIdentification(){

        $findMember = $this->memberService->verifyByDocumentNumber($this->document_number);

        if($findMember) {
            return redirect()->route('memberships.manage', $findMember);
        }

        $this->dispatch('open-registration-form-with-document', documento: $this->document_number);


    }
}
