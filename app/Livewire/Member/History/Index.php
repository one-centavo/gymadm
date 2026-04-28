<?php

namespace App\Livewire\Member\History;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Index extends Component
{
    public function render(): View
    {
        return view('livewire.member.history.index');
    }
}
