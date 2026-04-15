<?php
namespace App\Livewire\Member\History;

use App\Models\Membership;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class MemberHistory extends Component
{
use WithPagination;

public $search = '';
public $status = '';

public function updatingSearch() { $this->resetPage(); }

public function render()
{
$user = Auth::user();


$query = $user->memberships()
->with('membershipPlan')
->when($this->status, fn($q) => $q->where('status', $this->status))
->orderBy('end_date', 'desc');


$stats = [
'total_payments' => (clone $query)->count(),
'total_amount' => (clone $query)->sum('price_paid'),
];

return view('livewire.member.history.member-history', [
'transactions' => $query->paginate(10),
'stats' => $stats
]);
}
}
