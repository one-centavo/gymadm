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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'first_name'      => $this->nameRules(),
            'middle_name'     => $this->optionalNameRules(),
            'last_name'       => $this->nameRules(),
            'second_last_name' => $this->optionalNameRules(),
            'password'        => $this->passwordRules(true),
            'document_type'   => $this->documentRules()['document_type'],
            'document_number' => $this->documentRules()['document_number'],
            'phone_number'    => $this->phoneRules(),
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => 'El campo :attribute no debe superar :max caracteres.',
            'regex' => 'El formato de :attribute no es válido.',
            'confirmed' => 'La confirmación de la contraseña no coincide.',
            'in' => 'El valor seleccionado para :attribute no es válido.',
            'unique' => 'El :attribute ya está registrado.',
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name' => 'primer nombre',
            'middle_name' => 'segundo nombre',
            'last_name' => 'primer apellido',
            'second_last_name' => 'segundo apellido',
            'password' => 'contraseña',
            'password_confirmation' => 'confirmación de contraseña',
            'document_type' => 'tipo de documento',
            'document_number' => 'número de documento',
            'phone_number' => 'número de celular',
        ];
    }
}
