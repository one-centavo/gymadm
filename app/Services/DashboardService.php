<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Number;

class DashboardService
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function getMemberStats(User $user): array
    {
        $latestMembership = $user->memberships()
            ->with('membershipPlan')
            ->latest('end_date')
            ->first();

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
                'expired_day_month' => $vencimiento->translatedFormat('d \d\e F,'),
                'expired_year' => $vencimiento->format('Y'),
            ];
        }

        return [
            'status' => 'ACTIVO',
            'days_remaining' => (int) now()->startOfDay()->diffInDays($vencimiento->startOfDay()),
            'plan_name' => $latestMembership->membershipPlan->name,
            'plan_price' => '$ ' . number_format($latestMembership->membershipPlan->price, 0, ',', '.'),
            'expiry_day_month' => $vencimiento->translatedFormat('d \d\e F,'),
            'expiry_year' => $vencimiento->format('Y'),
            'next_payment' => $vencimiento->copy()->addDay()->translatedFormat('d M Y'),
        ];
    }
}
