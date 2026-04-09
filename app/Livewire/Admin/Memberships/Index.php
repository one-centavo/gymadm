<?php

namespace App\Livewire\Admin\Memberships;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Index extends Component
{

    public function render() : View
    {
        return view('livewire.membership.index');
    }
}
