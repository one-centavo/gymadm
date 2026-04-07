<?php

namespace App\Livewire\Plans;

use App\Http\Requests\Plan\CreateMembershipPlanRequest;
use App\Services\PlanService;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Log;
class CreatePlan extends Component
{
    public bool $open = false;
    public string $name = '';
    public string $description = '';
    public string $price = '';
    public string $duration_value = '';
    public string $duration_unit = '';


    public function create(PlanService $planService) : void
    {
        try{
            $request = new CreateMembershipPlanRequest();
            $validatedData = $this->validate(
                $request->rules(),
                $request->messages(),
                $request->attributes()
            );
            $planService->createPlan($validatedData);

            session()->flash('message', 'Plan creado exitosamente.');
            $this->dispatch('plan.created');

            $this->resetExcept('open');
            $this->open = false;
        }catch (QueryException $e){
            Log::error('Error creando plan de membresía', [
                'name' => $this->name,
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
            $this->addError('create', 'Error al registrar el plan');
        }
    }
}
