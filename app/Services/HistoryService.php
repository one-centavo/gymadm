<?php

namespace App\Services;

use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class HistoryService
{
    protected MembershipPlan $membershipPlanModel;
    protected Membership $membershipModel;
    protected User $userModel;

    public function getGeneralHistory() : LengthAwarePaginator
    {
        return $this->userModel
            ->from('users as u')
            ->select(
                'u.id as user_id',
                'u.document_number',
                'u.first_name',
                'u.last_name',
                'm.id as membership_id',
                'm.start_date',
                'm.end_date',
                'm.status as membership_status',
                'p.id as membership_plan_id',
                'p.name as plan_name',
            )->join('memberships as m', 'u.id', '=', 'm.user_id')
            ->join('membership_plans as p', 'm.membership_plan_id', '=', 'p.id')
            ->orderBy('m.end_date', 'desc')
            ->paginate(10);
    }
}
