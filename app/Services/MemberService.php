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
        $queryBase = $this->userModel->where('role', 'member');

        return [
            'total'    => (clone $queryBase)->count(),
            'active'   => (clone $queryBase)->where('status', 'active')->count(),
            'inactive' => (clone $queryBase)->where('status', 'inactive')->count(),
            'pending'  => (clone $queryBase)->where('status', 'pending')->count(),
        ];
    }

    public function getPaginatedList(string $search = '', string $statusFilter = 'all'): LengthAwarePaginator
    {
        $query = $this->userModel->where('role', 'member')->with('activeMembership');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('document_number', 'like', "%{$search}%");
            });
        }


        if (in_array($statusFilter, ['active', 'inactive', 'pending'])) {
            $query->where('status', $statusFilter);
        }

        return $query->latest()->paginate(10); // Ordenamos por lo más reciente
    }

    public function updateMemberInfo(int $id, array $data) : Void
    {
        $this->userModel
            ->where('id',$id)
            ->update([
                'first_name'      => $data['first_name'],
                'middle_name'     => $data['middle_name'] ?? null,
                'last_name'       => $data['last_name'],
                'second_lastname' => $data['second_lastname'] ?? null,
                'email'           => $data['email'],
                'document_type'   => $data['document_type'],
                'document_number' => $data['document_number'],
                'phone_number'    => $data['phone_number'],
            ]);
    }

    public function getMemberById(int $id): User
    {
        return $this->userModel->findOrFail($id);
    }

    public function toggleStatus(int $id): string
    {
        $user = $this->userModel->findOrFail($id);

        $newStatus = match ($user->status) {
            'active'  => 'inactive',
            'pending','inactive' => 'active'
        };

        $user->update(['status' => $newStatus]);

        return $newStatus;
    }
}
