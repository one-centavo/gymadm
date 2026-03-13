<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\UserValidationRules;

class VerifyOtpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    use UserValidationRules;
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => $this->emailRules(),
            'otp' => $this->otpRules(),
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'El correo es necesario para la validación.',
            'email.email'    => 'El formato del correo no es válido.',
            'otp.required'   => 'El código OTP es obligatorio.',
            'otp.numeric'    => 'El código OTP debe ser numérico.',
            'otp.digits'     => 'El código OTP debe tener exactamente 6 dígitos.',
        ];
    }
}
