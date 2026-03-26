<?php


namespace App\Livewire\Member;

use App\Http\Requests\User\UpdateMemberInfoRequest;
use App\Services\MemberService;
use Livewire\Attributes\On;
use Livewire\Component;

class UpdateMemberInfo extends Component
{
    public bool $open = false;

    public string $memberId = '';
    public string $first_name = '';
    public ?string $middle_name = '';
    public string $last_name = '';
    public ?string $second_lastname = '';
    public string $document_type = '';
    public string $document_number = '';
    public string $phone_number = '';
    public string $email = '';

    protected MemberService $memberService;

    public function boot(MemberService $service)
    {
        $this->memberService = $service;
    }

    #[On('open-edit-drawer')]
    public function loadMemberData($id)
    {
        $member = $this->memberService->getMemberById($id);
        $this->fill($member->toArray());
        $this->memberId = $id;
        $this->open = true;
    }

    public function update()
    {

        $request = new UpdateMemberInfoRequest();
        $validatedData = $this->validate(
            $request->rules((int)$this->memberId),
            $request->messages(),
            $request->attributes()
        );

        $this->memberService->updateMemberInfo($this->memberId,$this->all());
        $this->dispatch('member-updated');
        $this->open = false;

        session()->flash('message','Miembro actualizado correctamente.');
    }
}
