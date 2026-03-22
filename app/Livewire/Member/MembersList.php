<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Services\MemberService;
use Illuminate\View\View;

class MembersList extends Component
{
    public string $search = '';
    public string $statusFilter = '';
    public function render(MemberService $memberService) : View
    {
        $stats = $memberService->getMembersStats();
        $members = $memberService->getPaginatedList($this->search, $this->statusFilter);
        return view('livewire.member.members-list', [
            'stats' => $stats,
            'members' => $members
        ]);
    }

    public function setFilter(string $filter): void
    {
        $this->statusFilter = $filter;
        $this->resetPage();
    }
}
