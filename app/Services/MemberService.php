<?php

namespace App\Services;

use App\Models\User;
use App\Models\Membership;
use App\Services\OtpService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

class MemberService
{
    protected User $userModel;
    protected OtpService $otpService;

    public function __construct(User $user, OtpService $otpService){
        $this->userModel = $user;
        $this->otpService = $otpService;
    }

    public function registerMember(array $data) : User
    {

        $temporaryPassword = $this->generateTemporaryPassword();

        $this->otpService->send($data['email'],$temporaryPassword);

        return $this->userModel->create([
            'first_name'      => $data['first_name'],
            'middle_name'     => $data['middle_name'] ?? null,
            'last_name'       => $data['last_name'],
            'second_lastname' => $data['second_last_name'] ?? null,
            'email'           => $data['email'],
            'password'        => Hash::make($this->generateTemporaryPassword()),
            'document_type'   => $data['document_type'],
            'document_number' => $data['document_number'],
            'status'          => 'pending',
            'must_change_password' => true,
            'phone_number'    => $data['phone_number'],
            'role'            => 'member',
        ]);
    }

    public function generateTemporaryPassword(): string
    {
        return Str::password(8);
    }

    public function verifyByDocumentNumber(string $documentNumber) : ?User
    {
        return $this->userModel->where('document_number', $documentNumber)->first();
    }

    public function getMembersStats(): array
    {
        $today = now()->startOfDay();
        $daysForExpiring = now()->addDays(3)->endOfDay();
        $queryBase = $this->userModel->where('role', 'member');

        return [
            'total' => (clone $queryBase)->count(),

            'expiring' => (clone $queryBase)->whereHas('memberships', function ($query) use ($today, $daysForExpiring) {
                $query->whereBetween('end_date', [$today, $daysForExpiring]);
            })->count(),

            'expired' => (clone $queryBase)->whereHas('memberships', function ($query) use ($today) {
                $query->where('end_date', '<', $today);
            })->count()
        ];
    }

    public function getPaginatedList(string $search = '', string $statusFilter = 'all'): LengthAwarePaginator
    {
        $today = now()->startOfDay();

        $query = $this->userModel->select('users.*')
            ->distinct()
            ->where('role', 'member')
            ->with('activeMembership');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('document_number', 'like', "%{$search}%");
            });
        }

        // Aplicación de filtros de estado
        if ($statusFilter === 'active') {
            $query->whereHas('memberships', function ($q) use ($today) {
                $q->where('end_date', '>=', $today);
            });
        } elseif ($statusFilter === 'expired') {
            $query->whereHas('memberships', function ($q) use ($today) {
                $q->where('end_date', '<', $today);
            });
        } elseif ($statusFilter === 'expiring') {
            $query->whereHas('memberships', function ($q) use ($today) {
                $q->whereBetween('end_date', [$today, now()->addDays(3)]);
            });
        }

        return $query->orderBy(
            Membership::select('end_date')
                ->whereColumn('user_id', 'users.id')
                ->latest('end_date')
                ->limit(1),
            'asc'
        )->paginate(10);
    }
}
