<?php

namespace App\Http\Requests;

use App\Traits\UserValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    use UserValidationRules;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'first_name'      => $this->nameRules(),
            'middle_name'     => $this->optionalNameRules(), // <-- Ahora sí se valida si viene algo
            'last_name'       => $this->nameRules(),
            'second_lastname' => $this->optionalNameRules(), // <-- Validado contra tu migración
            'email'           => $this->emailRules(),
            'password'        => $this->passwordRules(true),
            'document_type'   => $this->documentRules()['document_type'],
            'document_number' => $this->documentRules()['document_number'],
            'phone_number'    => $this->phoneRules(),
        ];
    }
}
