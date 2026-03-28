<?php

namespace App\Traits;

use Illuminate\Validation\Rule;

trait PlanValidationRules
{
    protected function nameRules($ignorePlanId = null) : array
    {
        return [
            'required',
            'string',
            'max:50',
            'regex:/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/u',
            Rule::unique('membership_plans', 'name')->ignore($ignorePlanId)
        ];
    }

    protected function descriptionRules() : array
    {
        return [
            'nullable',
            'string',
            'max:255'
        ];
    }

    protected function priceRules() : array
    {
        return [
            'required',
            'numeric',
            'min:6000',
            'max:9999999.99'
        ];
    }

    protected function durationValueRules() : array
    {
        return [
            'required',
            'numeric',
            'min:1',
        ];
    }

    protected function durationUnitRules() : array
    {
        return [
            'required',
            'string',
            Rule::in(['days', 'weeks', 'months']),

        ];
    }





}
