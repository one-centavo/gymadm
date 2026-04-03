<?php

namespace App\Services;

use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Models\User;
use App\Data\AssignMembershipData;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function getPlanList(string $search = '', string $statusFilter = 'all'): LengthAwarePaginator
    {
        return $this->userModel->from('users as u')
            ->select(
                'u.id as user_id',
                'u.document_number',
                'u.first_name',
                'u.last_name',
                'm.id as membership_id',
                'm.end_date',
                'm.status as membership_status',
                'p.id as membership_plan_id',
                'p.name as plan_name',
                DB::raw('DATEDIFF(m.end_date, NOW()) as dias_restantes')
            )
            ->join('memberships as m', 'u.id', '=', 'm.user_id')
            ->join('membership_plans as p', 'm.membership_plan_id', '=', 'p.id')
            ->whereRaw('m.id = (SELECT MAX(id) FROM memberships WHERE user_id = u.id)')
            ->when($search, function ($query, $s) {
                $query->where(function ($q) use ($s) {
                    $q->where('u.first_name', 'LIKE', "%{$s}%")
                        ->orWhere('u.last_name', 'LIKE', "%{$s}%")
                        ->orWhere('u.document_number', 'LIKE', "%{$s}%");
                });
            })
            ->when($statusFilter !== 'all', function ($query) use ($statusFilter) {
                match ($statusFilter) {
                    'vigente' => $query->where('m.status', 'active')
                        ->whereRaw('DATEDIFF(m.end_date, NOW()) > 3'),
                    'por_vencer' => $query->where('m.status', 'active')
                        ->whereBetween(DB::raw('DATEDIFF(m.end_date, NOW())'), [0, 3]),
                    'vencido' => $query->whereBetween(DB::raw('DATEDIFF(m.end_date, NOW())'), [-15, -1]),
                    'cancelado' => $query->where('m.status', 'canceled'),
                    default => $query
                };
            })
            ->orderBy('dias_restantes')
            ->paginate(10);
    }


}
