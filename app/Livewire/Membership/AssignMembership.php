<?php

namespace App\Livewire\Membership;

use App\Services\SubscriptionService;
use Illuminate\Database\QueryException;
use Livewire\Component;
use App\Http\Requests\Membership\AssignMembershipRequest;
use App\Services\MemberService;
use App\Services\PlanService;
use Illuminate\Support\Facades\Log;
use App\Data\AssignMembershipData;
use Throwable;
use Carbon\Carbon;

class AssignMembership extends Component

{
    public string $searchTerm = '';
    public array $planOptions = [];
    public array $members = [];
    public bool $open = false;
	public ?int $userId = null;
	public ?int $planId = null;
	public string $paymentMethod = '';
	public string $startDate = '';
	public float $pricePaid = 0.0;
	// Opcional: Si se requiere mostrar la fecha de finalización en el formulario
	public string $endDate = '';

    public function updatedSearchTerm(MemberService $memberService): void
    {
        $term = trim($this->searchTerm);
        if ($term === '') {
            $this->members = [];
            return;
        }
        $results = $memberService->searchMembers($term);
        $this->members = $results->toArray();
    }

    public function selectMember(int $id): void
    {
        $this->userId = $id;
        $this->members = [];
        $this->searchTerm = '';
    }

    public function mount(PlanService $planService): void
    {
        $this->loadActivePlans($planService);
    }

    public function loadActivePlans(PlanService $planService): void
    {
        $this->planOptions = $planService->getActivePlanOptions()->toArray();
    }

    /**
     * Actualiza la fecha de inicio sugerida y la fecha de vencimiento calculada
     * según el usuario y plan seleccionados.
     * La fecha de inicio es editable, la de fin solo indicador.
     */
    public function updateSuggestedDates(SubscriptionService $subscriptionService): void
    {
        if ($this->userId > 0 && $this->planId > 0) {
            $dates = $subscriptionService->getSuggestedMembershipDates($this->userId, $this->planId);
            $this->startDate = $dates['start_date']->toDateString();
            $this->endDate = $dates['end_date']->toDateString();
            // Asignar el precio del plan seleccionado
            $plan = collect($this->planOptions)->firstWhere('id', $this->planId);
            $this->pricePaid = $plan['price'] ?? 0.0;
        } else {
            $this->startDate = '';
            $this->endDate = '';
            $this->pricePaid = 0.0;
        }
    }




    public function assign(SubscriptionService $subscriptionService) : void
    {
        $request = new AssignMembershipRequest();
        $validatedData = $this->validate(
            $request->rules(),
            $request->messages(),
            $request->attributes()
        );

        Log::debug('AssignMembership validated data', $validatedData);
        try{


            $dto = new AssignMembershipData(
                userId: (int) $validatedData['userId'],
                planId: (int) $validatedData['planId'],
                paymentMethod: $validatedData['paymentMethod'],
                startDate: Carbon::parse($validatedData['startDate']),
            );
            $subscriptionService->assignMembership($dto);

            session()->flash('success', 'Membresía asignada correctamente.');
            $this->resetExcept('open');
            $this->open = false;
            $this->dispatch('membership.assigned');

        }catch(QueryException $e){
            Log::error('Error al asignar la membresía', [
                'name' => $this->name,
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
            $this->addError('assign', 'Error al asignar la membresía');
        }catch (Throwable $e){
            Log::error('Error inesperado al asignar la membresía', [
                'name' => $this->name ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->addError('assign', 'Ocurrió un error inesperado al asignar la membresía. Por favor, intenta nuevamente.');
        }

    }
}
