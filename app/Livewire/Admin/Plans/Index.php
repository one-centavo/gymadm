<?php

namespace App\Livewire\Admin\Plans;

use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Index extends Component
{

    public function render() : View
    {
        return view('livewire.admin.plans.index');
    }
}
