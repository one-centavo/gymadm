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

    public function getUserHistory(User $user, array $filters = []): array
    {
        $query = $user->memberships()
            ->with('membershipPlan')
            ->orderBy('end_date', 'desc');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $stats = [
            'total_count' => (clone $query)->count(),
            'total_amount' => (clone $query)->sum('price_paid'),
        ];

        return [
            'transactions' => $query->paginate(10),
            'stats' => $stats
        ];
    }
}
