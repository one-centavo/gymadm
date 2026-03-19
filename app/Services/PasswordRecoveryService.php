<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
use Exception;

use Validator;

class PasswordRecoveryService
{
    protected OtpService $otpService;
    protected User $user;
    public function __construct(OtpService $otpService, User $user){
        $this->otpService = $otpService;
        $this->user = $user;
    }

    public function requestRecovery(string $email): void
    {
        try{

            $code = $this->otpService->generate($email);
            $this->otpService->send($email, $code);

        }catch(Exception $exception){
            logger($exception);
            throw new RuntimeException('Error al intentar enviar el código. Intenta de nuevo.');
        }
    }

    public function validateRecoveryCode(string $email, string $code): bool
    {
        return $this->otpService->validate($email, $code);
    }

    public function resetPassword(string $email, string $password): bool
    {
        $user = User::where('email', $email)->first();
        if(!$user){
            throw new ModelNotFoundException('User not found');
        }
        $user->password = Hash::make($password);
        $user->save();
        return true;
    }
}
