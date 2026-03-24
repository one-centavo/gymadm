<?php

namespace App\Livewire\Member;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\MemberService;
class ToggleStatusMember extends Component // <-- Corregida la "O" mayúscula
{
    public bool $confirmingStatusChange = false;
    public int $selectedMemberId;
    public string $selectedMemberName = '';
    public string $currentStatus = '';
    public string $targetStatus = '';

    // Escuchamos el evento que dispara el botón
    #[On('open-status-modal')]
    public function confirmStatusChange($id, MemberService $memberService)
    {
        $member = $memberService->getMemberById($id);

        $this->selectedMemberId = $id;
        $this->selectedMemberName = $member->first_name . ' ' . $member->last_name;
        $this->currentStatus = $member->status;

        $this->targetStatus = match ($member->status) {
            'active'  => 'inactive',
            'pending', 'inactive' => 'active',
            default => 'active'
        };

        $this->confirmingStatusChange = true;
    }

    public function updateStatus(MemberService $memberService)
    {
        $memberService->toggleStatus($this->selectedMemberId);

        $this->confirmingStatusChange = false;
        $this->dispatch('member-updated');
    }
}
