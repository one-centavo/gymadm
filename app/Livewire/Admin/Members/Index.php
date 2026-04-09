<?php

namespace App\Livewire\Admin\Members;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Index extends Component
{

    public function render() : View
    {
        return view('livewire.admin.members.index');
    }
}
