<?php

namespace App\Livewire\Admin\History;

use App\Services\HistoryService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\View\View;

class GeneralHistory extends Component
{
    use WithPagination;


    public function render(HistoryService $historyService): View
    {
        $data = $historyService->getGeneralHistory();

        return view('livewire.admin.history.general-history', [
            'transactions' => $data['transactions'],
            'stats'        => $data['stats'],
        ]);
    }
}
