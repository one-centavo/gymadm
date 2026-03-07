<?php

namespace App\Services;
use App\Models\SecurityCode;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\SecurityCodeMail;
use Illuminate\Database\QueryException;
use Exception;
use Throwable;

class OtpService
{

    /**
     * @param string $email
     * @return string
     * @throws RuntimeException
     */
    public function generate(string $email): string {
        $lastCode = SecurityCode::where('email', $email)->latest()->first();
        try {

            if ($lastCode && $lastCode->created_at->addMinute()->isFuture()) {
                $seconds = now()->diffInSeconds($lastCode->created_at->addMinute());
                throw new RuntimeException("Debes esperar $seconds segundos antes de solicitar un nuevo código.");
            }

            $code = random_int(100000, 999999);
            SecurityCode::create([
                'email' => $email,

                // We keep the code hashed for security reasons and check it using Hash::check when validating the code later.
                'code' => Hash::make($code),
                'expires_at' => now()->addMinutes(10),
            ]);

            return (string)$code;
        } catch (QueryException $e) {

            Log::critical("Base de datos fuera de servicio: " . $e->getMessage());
            throw new RuntimeException("Servicio temporalmente no disponible.");
        }catch (Exception $e) {
            Log::error("Error al generar el código OTP: " . $e->getMessage());
            throw new RuntimeException("Error al generar el código OTP.");
        }


    }

    public function send(string $email, string $code): void {
        try{
            Mail::to($email)->send(new SecurityCodeMail($code));
        }catch(Throwable $e){
            Log::error($e->getMessage());
                throw new RuntimeException("Failed to send OTP code.");
        }

    }

    public function validate(string $email, string $code): bool {
        $record = SecurityCode::where('email', $email)->whereNUll('used_at')->latest()->first();

        if (!$record || $this->validateCodeExpiration($email) === false) {
            return false;
        }

        if(Hash::check($code, $record->code)){
            $this->markAsUsed($email);
            return true;
        }

        return false;
    }

    public function markAsUsed(string $email): void {
        SecurityCode::where('email', $email)
            ->whereNull('used_at')
            ->update(['used_at' => now()]);
    }

    public function validateCodeExpiration(string $email): bool {
        $record = SecurityCode::where('email', $email)->whereNull('used_at')->latest()->first();

        if (!$record) {
            return false;
        }

        return Carbon::now()->lessThanOrEqualTo($record->expires_at);
    }
}
