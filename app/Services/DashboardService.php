<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class DashboardService
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function getMemberStats(User $user): array
    {
        $activeMembership = $user->memberships()->where('status', 'active')->first();

        if (!$activeMembership) {
            return [
                'status' => 'INACTIVO',
                'days_remaining' => 0,
            ];
        }

        $vencimiento = Carbon::parse($activeMembership->end_date);

        return [
            'status' => 'ACTIVO',
            'days_remaining' => now()->diffInDays($vencimiento),
            'next_payment' => $vencimiento->format('d M Y'),
            'plan_name' => $activeMembership->plan->name,
            'monthly_cost' => number_format($activeMembership->plan->price, 0, ',', '.'),
            'progress_percentage' => $this->calculateProgress($activeMembership->start_date, $activeMembership->end_date)
        ];
    }

    private function calculateProgress($start, $end) : int
    {
        $total = Carbon::parse($start)->diffInDays(Carbon::parse($end));
        $remaining = now()->diffInDays(Carbon::parse($end));
        return $total > 0 ? ($remaining / $total) * 100 : 0;
    }
}
