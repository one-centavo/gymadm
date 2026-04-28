<?php

namespace App\Services;

use App\Models\User;
use RuntimeException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Exception;

class RegistrationService
{
    public function __construct(
        protected User       $userModel,
        protected OtpService $otpService
    ) {}

    public function isEmailAvailable(string $email): bool
    {
        return !$this->userModel->where('email', $email)->exists();
    }

    public function verifyIdentity(string $email, string $code): bool
    {
        return $this->otpService->validate($email, $code);
    }

    public function checkDocumentUniqueness(string $type, string $number): bool
    {
        return !$this->userModel->where('document_type', $type)
            ->where('document_number', $number)
            ->exists();
    }

    public function requestEmailVerification(string $email): void
    {
        if (!$this->isEmailAvailable($email)) {
            throw new RuntimeException("This email address is already registered.");
        }

        try {
            $code = $this->otpService->generate($email);
            $this->otpService->send($email, $code);
        } catch (RuntimeException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error("Failed to send registration OTP to {$email}: " . $e->getMessage());
            throw new RuntimeException("We couldn't send the verification code. Please try again later.");
        }
    }

    public function registerByMember(array $data): User
    {
        return $this->userModel->create([
            'first_name'      => $data['first_name'],
            'middle_name'     => $data['middle_name'] ?? null,
            'last_name'       => $data['last_name'],
            'second_lastname' => $data['second_last_name'] ?? null,
            'email'           => $data['email'],
            'password'        => Hash::make($data['password']),
            'document_type'   => $data['document_type'],
            'document_number' => $data['document_number'],
            'status'          => 'pending',
            'phone_number'    => $data['phone_number'],
            'role'            => 'member',
        ]);
    }
}

