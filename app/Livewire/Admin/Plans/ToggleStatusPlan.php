<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Plans;

use App\Services\PlanService;
use Livewire\Attributes\On;
use Livewire\Component;

class ToggleStatusPlan extends Component
{
    public bool $confirmingStatusChange = false;
    public int $selectedPlanId;
    public string $selectedPlanName = '';
    public string $currentStatus = '';
    public string $targetStatus = '';

    #[On('open-plans-status-modal')]
    public function confirmStatusChange(int $id, PlanService $planService): void
    {
        $plan = $planService->getPlanInfoById($id);

        $this->selectedPlanId = $id;
        $this->selectedPlanName = $plan->name;
        $this->currentStatus = $plan->status;

        $this->targetStatus = match ($plan->status) {
            'active' => 'inactive',
            'inactive' => 'active',
            default => 'active',
        };

        $this->confirmingStatusChange = true;
    }

    public function updateStatus(PlanService $planService): void
    {
        $planService->toggleStatus($this->selectedPlanId);

        $this->confirmingStatusChange = false;
        $this->dispatch('plans.updated');
    }
}
