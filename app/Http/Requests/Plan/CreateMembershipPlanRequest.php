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
}
