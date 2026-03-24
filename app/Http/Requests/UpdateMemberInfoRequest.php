<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\UserValidationRules;

class UpdateMemberInfoRequest extends FormRequest
{
    use UserValidationRules;


    public function rules(?int $memberId = null): array
    {
        $documentRules = $this->documentRules($memberId);

        return [
            'first_name'      => $this->nameRules(),
            'middle_name'     => $this->optionalNameRules(),
            'last_name'       => $this->nameRules(),
            'second_lastname' => $this->optionalNameRules(),
            'document_type'   => $documentRules['document_type'],
            'document_number' => $documentRules['document_number'],
            'phone_number'    => $this->phoneRules(true, $memberId),
            'email'           => $this->emailRules(true, $memberId),
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
            'second_lastname' => 'segundo apellido',
            'document_type' => 'tipo de documento',
            'document_number' => 'número de documento',
            'phone_number' => 'número de celular',
            'email' => 'correo electrónico',
        ];
    }
}
