<?php

namespace App\Http\Requests;

use App\Traits\UserValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRecoveryOtpRequest extends FormRequest
{
    use UserValidationRules;

    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $rules = $this->emailRules(false); // Quitamos el 'unique'
        $rules[] = 'exists:users,email';   // Forzamos que DEBA existir

        return ['email' => $rules];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required',
            'email.exists'   => 'Email is invalid, try again',
        ];
    }
}
