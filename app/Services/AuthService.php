<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    protected User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function login(array $credentials) : bool{
        $user = $this->userModel->where('email', $credentials['email'])->first();

        if ($user && password_verify($credentials['password'], $user->password)) {
            auth()->login($user);
            session()->regenerate();
            return true;
        }

        return false;
    }
}
