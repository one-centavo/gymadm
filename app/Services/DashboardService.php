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

        $latestMembership = $user->memberships()->latest('end_date')->first();

        if (!$latestMembership) {
            return [
                'status' => 'PENDIENTE',
                'message' => '¡Bienvenido! Acércate a recepción para activar tu plan.',
            ];
        }

        $vencimiento = Carbon::parse($latestMembership->end_date);
        $isExpired = $vencimiento->isPast();

        if ($isExpired || $latestMembership->status === 'inactive') {
            return [
                'status' => 'INACTIVO',
                'expired_at' => $vencimiento->format('d/m/Y'),
                /*'plan_name' => $latestMembership->plan->name,*/
            ];
        }

        return [
            'status' => 'ACTIVO',
            'days_remaining' => now()->diffInDays($vencimiento),
        ];
    }
}
