<?php

namespace App\Livewire\Admin\Memberships;

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
        'membership.renewed' => '$refresh',
    ];

    public function render(SubscriptionService $subscriptionService) : View
    {
        $memberships = $subscriptionService->getPlanList($this->search, $this->statusFilter);

        return view('livewire.admin.memberships.memberships-list', [
            'memberships' => $memberships,
        ]);
    }

    public function setFilter(string $filter): void
    {
        $this->statusFilter = $filter;
        $this->resetPage();
    }
}
