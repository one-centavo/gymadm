<?php

namespace App\Services;

use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Models\User;
use App\Data\AssignMembershipData;
use Illuminate\Support\Carbon;
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

    public function assignMembership(AssignMembershipData $data): Membership
    {
        $member = $this->userModel->where('role','member')->findOrFail($data->userId);
        $plan = $this->membershipPlanModel->where('status','active')->findOrFail($data->planId);
        $startDate = Carbon::instance($data->startDate)->startOfDay();
        $endDate = $this->calculateEndDate($data->startDate, $plan->duration_value, $plan->duration_unit);

        return $this->membershipModel->create([
            'user_id' => $member->id,
            'membership_plan_id' => $plan->id,
            'payment_method' => $data->paymentMethod,
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'price_paid' => $plan->price,
            'status' => 'active'
        ]);

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

}
