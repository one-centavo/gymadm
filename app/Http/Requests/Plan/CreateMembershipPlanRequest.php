<?php

namespace App\Http\Requests\Plan;

use App\Traits\PlanValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class CreateMembershipPlanRequest extends FormRequest
{

    use PlanValidationRules;
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
            'name' => $this->nameRules(),
            'description' => $this->descriptionRules(),
            'price' => $this->priceRules(),
            'duration_value' => $this->durationValueRules(),
            'duration_unit' => $this->durationUnitRules(),
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'numeric' => 'El campo :attribute debe ser un valor numérico.',
            'max.string' => 'El campo :attribute no debe superar :max caracteres.',
            'max.numeric' => 'El campo :attribute no debe ser mayor que :max.',
            'min.numeric' => 'El campo :attribute debe ser al menos :min.',
            'regex' => 'El formato de :attribute no es válido.',
            'unique' => 'El campo :attribute ya está registrado.',
            'in' => 'El valor seleccionado para :attribute no es válido.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre del plan',
            'description' => 'descripción del plan',
            'price' => 'precio',
            'duration_value' => 'duración',
            'duration_unit' => 'unidad de duración',
        ];
    }
}
