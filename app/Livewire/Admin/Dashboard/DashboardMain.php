<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Services\DashboardService;

class DashboardMain extends Component
{
    public function render(DashboardService $service)
    {
        return view('livewire.admin.dashboard.dashboard-main', [
            'kpis' => $service->getKpis(),
            'recentMembers' => $service->getRecentMembers(),
        ]);
    }
}
