<?php

namespace App\Traits;

use Illuminate\Validation\Rules\Password;


trait UserValidationRules
{
    protected function nameRules(): array{
        return ['required', 'string', 'max:50', 'regex:/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/u'];
    }

    protected function optionalNameRules() : array {
        return ['nullable', 'string', 'max:50', 'regex:/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/u'];
    }

    protected function emailRules($isUnique = true): array{
        $rules = ['required', 'string', 'email', 'max:255'];

        if($isUnique){
            $rules[] = 'unique:users,email';
        }

        return $rules;
    }

    protected function documentRules(): array {
        return [
            'document_type' => ['required', 'string', 'max:10', 'in:CC,TI,CE,PP'],
            'document_number' => ['required', 'string', 'max:20', 'unique:users,document_number'],
        ];
    }

    protected function passwordRules($isNew = true) : array {
        return $isNew
            ? ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()]
            : ['required'];
    }

    protected function phoneRules() : array {
        return ['required', 'string', 'max:50', 'unique:users,phone_number'];
    }

    protected function otpRules(): array{
        return ['required', 'string', 'size:6', 'numeric'];
    }
}
