<?php
namespace App\Livewire\Membership;

use App\Services\SubscriptionService;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\On; // Importante para los eventos

class CancelMembership extends Component
{
public bool $openModal = false;
public string $reason = '';
public ?int $membershipId = null; // Lo hacemos opcional inicialmente

protected array $rules = [
'reason' => 'required|min:5|max:255',
];

#[On('open-cancel-modal')]
public function openCancelModal(int $id): void
{
$this->membershipId = $id;
$this->openModal = true;
}

public function closeModal(): void
{
$this->openModal = false;
$this->resetErrorBag();
$this->reset(['reason', 'membershipId']);
}

public function cancel(SubscriptionService $subscriptionService): void
{
$this->validate();

if ($this->membershipId) {
$subscriptionService->cancelMembership($this->membershipId, $this->reason);

$this->dispatch('membership.cancelled');
$this->dispatch('message', 'La membresía ha sido cancelada correctamente.');

$this->closeModal();
}
}

public function render(): View
{
return view('livewire.membership.cancel-membership');
}
}
