<?php

namespace App\Services;

use App\Models\User;
use App\Services\OtpService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
}
