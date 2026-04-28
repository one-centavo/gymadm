<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Memberships;

use App\Data\AssignMembershipData;
use App\Services\PlanService;
use App\Services\SubscriptionService;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Component;
use Throwable;

class RenewMembership extends Component
{
    public ?int $userId = null;
    public ?int $planId = null;
    public array $planOptions = [];
    public string $startDate = '';
    public string $endDate = '';
    public string $paymentMethod = '';
    public float $pricePaid = 0.0;
    public ?string $selectedMemberName = null;
    public ?string $selectedMemberDocument = null;
    public bool $open = false;

    protected $listeners = [
        'renew-membership-form' => 'openRenewForm',
    ];

    public function openRenewForm($userId, SubscriptionService $subscriptionService, PlanService $planService): void
    {
        $this->userId = $userId;
        $this->open = true;
        $this->loadMemberData($subscriptionService);
        $this->loadActivePlans($planService);
    }

    private function loadMemberData(SubscriptionService $subscriptionService): void
    {
        $latestMembership = $subscriptionService->getLatestMembership($this->userId);
        if (!$latestMembership) {
            abort(404, 'No se encontró membresía previa para renovar.');
        }
        $user = $latestMembership->user;
        $this->selectedMemberName = ($user->first_name ?? '') . ' ' . ($user->last_name ?? '');
        $this->selectedMemberDocument = $user->document_number ?? '';
        $this->planId = $latestMembership->membership_plan_id;
        $this->paymentMethod = '';
        $dates = $subscriptionService->getSuggestedMembershipDates($this->userId, $this->planId);
        $this->startDate = $dates['start_date']->toDateString();
        $this->endDate = $dates['end_date']->toDateString();
        $this->pricePaid = isset($latestMembership->plan->price) ? (float) $latestMembership->plan->price : 0.0;
    }

    public function loadActivePlans(PlanService $planService): void
    {
        $this->planOptions = $planService->getActivePlanOptions()->toArray();
    }

    public function updatedPlanId(SubscriptionService $subscriptionService): void
    {
        $this->updateSuggestedDates($subscriptionService);
    }

    public function updatedStartDate(SubscriptionService $subscriptionService): void
    {
        $this->updateSuggestedDates($subscriptionService);
    }

    private function updateSuggestedDates(SubscriptionService $subscriptionService): void
    {
        if ($this->userId > 0 && $this->planId > 0 && $this->startDate !== '') {
            $plan = collect($this->planOptions)->firstWhere('id', $this->planId);
            $dates = $subscriptionService->getSuggestedMembershipDates($this->userId, $this->planId);
            try {
                $effectiveStartDate = Carbon::parse($this->startDate);
            } catch (Throwable $e) {
                $effectiveStartDate = $dates['start_date']->copy();
                $this->startDate = $effectiveStartDate->toDateString();
            }
            $durationInDays = $dates['start_date']->diffInDays($dates['end_date']);
            $this->endDate = $effectiveStartDate->copy()->addDays($durationInDays)->toDateString();
            $this->pricePaid = isset($plan['price']) ? (float) $plan['price'] : 0.0;
        } else {
            $this->endDate = '';
            $this->pricePaid = 0.0;
        }
    }

    public function renew(SubscriptionService $subscriptionService): void
    {
        $validated = $this->validate([
            'userId' => 'required|integer|exists:users,id',
            'planId' => 'required|integer|exists:membership_plans,id',
            'startDate' => 'required|date',
            'paymentMethod' => 'required|string',
        ], [], [
            'userId' => 'miembro',
            'planId' => 'plans',
            'startDate' => 'fecha de inicio',
            'paymentMethod' => 'método de pago',
        ]);

        Log::debug('RenewMembership validated data', $validated);
        try {
            $dto = new AssignMembershipData(
                userId: (int) $validated['userId'],
                planId: (int) $validated['planId'],
                paymentMethod: $validated['paymentMethod'],
                startDate: Carbon::parse($validated['startDate'])
            );
            $subscriptionService->assignMembership($dto);
            session()->flash('success', 'Membresía renovada correctamente.');
            $this->resetExcept('open');
            $this->open = false;
            $this->dispatch('membership.renewed');
        } catch (QueryException $e) {
            Log::error('Error al renovar la membresía', [
                'userId' => $validated['userId'] ?? null,
                'planId' => $validated['planId'] ?? null,
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
            $this->addError('renew', 'Error al renovar la membresía');
        } catch (Throwable $e) {
            Log::error('Error inesperado al renovar la membresía', [
                'userId' => $validated['userId'] ?? null,
                'planId' => $validated['planId'] ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->addError('renew', 'Ocurrió un error inesperado al renovar la membresía. Por favor, intenta nuevamente.');
        }
    }

    public function render() : View
    {
        return view('livewire.admin.memberships.renew-membership');
    }
}
