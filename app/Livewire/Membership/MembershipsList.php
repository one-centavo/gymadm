<?php

namespace App\Livewire\Membership;

use App\Services\SubscriptionService;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class MembershipsList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = 'all';

    protected $listeners = [
        'membership.assigned' => '$refresh',
    ];

    public function render(SubscriptionService $subscriptionService) : View
    {
        $memberships = $subscriptionService->getPlanList($this->search, $this->statusFilter);

        return view('livewire.membership.memberships-list', [
            'memberships' => $memberships,
        ]);
    }

    public function setFilter(string $filter): void
    {
        $this->statusFilter = $filter;
        $this->resetPage();
    }
}
