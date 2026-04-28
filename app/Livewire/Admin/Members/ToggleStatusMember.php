<?php

namespace App\Livewire\Admin\Members;

use App\Services\MemberService;
use Livewire\Attributes\On;
use Livewire\Component;

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
