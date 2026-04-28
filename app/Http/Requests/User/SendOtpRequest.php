<?php

namespace App\Http\Requests\User;

use App\Traits\UserValidationRules;
use Illuminate\Foundation\Http\FormRequest;


class SendOtpRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email is invalid, try again',
            'email.max' => 'Email must not exceed 255 characters',
        ];
    }
}
