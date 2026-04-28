<?php

namespace App\Http\Requests\User;

use App\Traits\UserValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRecoveryRequest extends FormRequest
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
            'password' => $this->passwordRules(),
        ];
    }
}
