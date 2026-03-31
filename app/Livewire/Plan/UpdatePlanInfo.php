<?php

namespace App\Livewire\Plan;

use App\Http\Requests\Plan\EditMembershipPlanRequest;
use App\Services\PlanService;
use Illuminate\Database\QueryException;
use Livewire\Attributes\On;
use Livewire\Component;
use Log;

class UpdatePlanInfo extends Component
{
    public bool $open = false;
    public ?int $planId = null;
    public string $name = '';
    public ?string $description = '';
    public string $price = '';
    public string $duration_value = '';
    public string $duration_unit = '';

    protected PlanService $planService;

    public function boot(PlanService $planService)
    {
        $this->planService = $planService;
    }

    #[On('open-edit-plan')]
    public function loadPlanData(int $id): void
    {
        $this->reset(['name', 'description', 'price', 'duration_value', 'duration_unit', 'planId']);

        $plan = $this->planService->getPlanInfoById($id);

        $this->fill($plan->only([
            'name',
            'description',
            'price',
            'duration_value',
            'duration_unit',
        ]));

        $this->planId = $id;
        $this->resetErrorBag();
        $this->open = true;
    }

    public function update() : void
    {
        if ($this->planId === null) {
            return;
        }

        try{
            $request = new EditMembershipPlanRequest();
            $validatedData = $this->validate(
                $request->rules($this->planId),
                $request->messages(),
                $request->attributes()

            );

            $this->planService->updatePlan($this->planId, $validatedData);
            $this->dispatch('plan.updated');
            $this->open = false;

        }catch (QueryException $e){
            Log::error('Error al editar el plan de membresía', [
                'plan_id' => $this->planId,
                'name' => $this->name,
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
            $this->addError('update', 'Error al actualizar el plan');
        }



    }




}
