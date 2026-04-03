<?php

namespace App\Services;

use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Models\User;
use App\Data\AssignMembershipData;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use DateTimeInterface;

class SubscriptionService
{
    protected MembershipPlan $membershipPlanModel;
    protected Membership $membershipModel;
    protected User $userModel;


    public function __construct(MembershipPlan $membershipPlanModel, Membership $membershipModel, User $userModel)
    {
        $this->membershipPlanModel = $membershipPlanModel;
        $this->membershipModel = $membershipModel;
        $this->userModel = $userModel;
    }

    /**
     * @throws \Throwable
     */
    public function assignMembership(AssignMembershipData $data): Membership
    {
        $member = $this->userModel->where('role','member')->findOrFail($data->userId);
        $plan = $this->membershipPlanModel->where('status','active')->findOrFail($data->planId);
        $startDate = Carbon::instance($data->startDate)->startOfDay();

        return DB::transaction(function () use ($member, $plan, $startDate, $data) {
            $endDate = $this->calculateEndDate($startDate, $plan->duration_value, $plan->duration_unit);

            $membership = $this->membershipModel->create([
                'user_id' => $member->id,
                'membership_plan_id' => $plan->id,
                'payment_method' => $data->paymentMethod,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'price_paid' => $plan->price,
                'status' => 'active'
            ]);

            if ($member->status === 'inactive' || $member->status === 'pending') {
                $member->status = 'active';
                $member->save();
            }

            return $membership;
        });

    }

    private function calculateEndDate(
        DateTimeInterface $startDate,
        int $durationValue,
        string $durationUnit
    ): Carbon {
        $date = Carbon::instance($startDate)->startOfDay();

        return match ($durationUnit) {
            'days' => $date->copy()->addDays($durationValue),
            'weeks' => $date->copy()->addWeeks($durationValue),
            'months' => $date->copy()->addMonthsWithOverflow($durationValue),
            default => throw new InvalidArgumentException(
                "Unsupported duration unit: $durationUnit"
            ),
        };
    }

    /**
     * Sugiere la fecha de inicio y calcula la fecha de vencimiento para la asignación de membresía.
     * Si el usuario tiene una membresía vigente, la fecha sugerida es el día siguiente al fin de la membresía.
     * Si no, la fecha sugerida es hoy.
     * Retorna un array con 'start_date' y 'end_date' (ambos Carbon).
     */
    public function getSuggestedMembershipDates(int $userId, int $planId): array
    {
        $today = Carbon::today();
        $activeMembership = $this->membershipModel
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', $today)
            ->orderByDesc('end_date')
            ->first();

        $plan = $this->membershipPlanModel->where('status', 'active')->findOrFail($planId);

        if ($activeMembership) {
            $startDate = Carbon::parse($activeMembership->end_date)->addDay()->startOfDay();
        } else {
            $startDate = $today->copy()->startOfDay();
        }

        $endDate = $this->calculateEndDate($startDate, $plan->duration_value, $plan->duration_unit);

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }

}
