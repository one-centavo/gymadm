<?php

declare(strict_types=1);

namespace App\Http\Requests\Membership;

use App\Traits\MembershipValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class AssignmentMembershipRequest extends FormRequest
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
            'user_id' => $this->userIdRules(),
            'membership_plan_id' => $this->membershipPlanIdRules(),
            'start_date' => $this->startDateRules(),
            'payment_method' => $this->paymentMethodRules(),
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
            'user_id' => 'miembro',
            'membership_plan_id' => 'plan de membresía',
            'start_date' => 'fecha de inicio',
            'payment_method' => 'método de pago',
        ];
    }
}
