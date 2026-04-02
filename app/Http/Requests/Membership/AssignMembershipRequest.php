<?php

declare(strict_types=1);

namespace App\Http\Requests\Membership;

use App\Traits\MembershipValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class AssignMembershipRequest extends FormRequest
{
    use MembershipValidationRules;

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
    public function rules(): array
    {
        return [
            'userId' => $this->userIdRules(),
            'planId' => $this->membershipPlanIdRules(),
            'startDate' => $this->startDateRules(),
            'paymentMethod' => $this->paymentMethodRules(),
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'string' => 'El campo :attribute debe ser texto.',
            'date' => 'El campo :attribute debe ser una fecha válida.',
            'max.string' => 'El campo :attribute no debe superar :max caracteres.',
            'exists' => 'El :attribute seleccionado no es válido.',
            'in' => 'El valor seleccionado para :attribute no es válido.',
        ];
    }

    public function attributes(): array
    {
        return [
            'userId' => 'miembro',
            'planId' => 'plan de membresía',
            'startDate' => 'fecha de inicio',
            'paymentMethod' => 'método de pago',
        ];
    }
}
