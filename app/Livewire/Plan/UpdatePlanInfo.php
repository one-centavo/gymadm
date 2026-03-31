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
    public string $planId = '';
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
        $plan = $this->planService->getPlanInfoById($id);

        $this->fill($plan->only([
            'name',
            'description',
            'price',
            'duration_value',
            'duration_unit',
        ]));

        $this->planId = (string) $id;
        $this->resetErrorBag();
        $this->open = true;
    }

    public function update() : void
    {
        try{
            $request = new EditMembershipPlanRequest();
            $validatedData = $this->validate(
                $request->rules((int) $this->planId),
                $request->messages(),
                $request->attributes()

            );

            $this->planService->updatePlan($this->planId, $validatedData);
            $this->dispatch('plan-updated');
            $this->open = false;

        }catch (QueryException $e){
            Log::error('Error creando plan de membresía', [
                'name' => $this->name,
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
            $this->addError('update', 'Error al actualizar el plan');
        }



    }




}
