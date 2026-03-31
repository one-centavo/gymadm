<?php

namespace App\Livewire\Plan;

use App\Services\PlanService;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class PlansList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = 'all';

    protected $listeners = [
        'plan.created' => '$refresh',
        'plan-updated' => '$refresh',
    ];

    public function render(PlanService $planService): View
    {
        $stats = $planService->getPlanStats();
        $plans = $planService->getPlanList($this->search, $this->statusFilter);

        return view('livewire.plan.plans-list', [
            'plans' => $plans,
            'stats' => $stats,
        ]);
    }

    public function setFilter(string $filter): void
    {
        $this->statusFilter = $filter;
        $this->resetPage();
    }
}
