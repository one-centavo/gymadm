<?php

namespace App\Livewire\Member\Dashboard;

use App\Services\DashboardService;
use Livewire\Component;

class MemberStats extends Component
{
    public array $stats;

    public function mount(DashboardService $service)
    {
        // Obtenemos las estadísticas del usuario logueado usando tu nuevo servicio
        $this->stats = $service->getMemberStats(auth()->user());
    }

    public function render()
    {
        return view('livewire.member.dashboard.member-stats');
    }
}
