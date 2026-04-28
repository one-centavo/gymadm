<?php

namespace App\Traits;

use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

trait UserValidationRules
{
    protected function nameRules(): array{
        return ['required', 'string', 'max:50', 'regex:/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/u'];
    }

    protected function optionalNameRules() : array {
        return ['nullable', 'string', 'max:50', 'regex:/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/u'];
    }

    protected function emailRules(bool $isUnique = true, ?int $ignoreUserId = null): array{
        $rules = ['required', 'string', 'email', 'max:255'];

        if ($isUnique) {
            $rules[] = Rule::unique('users', 'email')->ignore($ignoreUserId);
        }

        return $rules;
    }

    protected function documentRules(?int $ignoreUserId = null): array {
        return [
            'document_type' => ['required', 'string', 'max:10', 'in:CC,TI,CE,PP'],
            'document_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'document_number')->ignore($ignoreUserId)
            ],
        ];
    }

    protected function passwordRules($isNew = true) : array {
        return $isNew
            ? ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()]
            : ['required'];
    }

    protected function phoneRules(bool $isUnique = true, ?int $ignoreUserId = null) : array {
        $rules = ['required', 'string', 'max:50'];

        if ($isUnique) {
            $rules[] = Rule::unique('users', 'phone_number')->ignore($ignoreUserId);
        }

        return $rules;
    }

    protected function otpRules(): array{
        return ['required','numeric','digits:6'];
    }
}
