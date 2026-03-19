<?php

use App\Livewire\Auth\RecoveryForm;
use App\Livewire\Auth\RegisterForm;
use App\Livewire\Auth\LoginForm;
use App\Livewire\Dashboard\Index;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');



Route::middleware('guest')->group(function () {
    Route::get('/login', LoginForm::class)->name('login');
    Route::get('/register', RegisterForm::class)->name('register');
    Route::get('recovery-account', RecoveryForm::class)->name('recovery-account');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Index::class)->name('dashboard');

    Route::post('/logout', function (Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');

    Route::get('/miembros', function () {
        return view('members.index');
    })->name('members.index');

    Route::get('/membresias', function () {
        return view('memberships.index');
    })->name('memberships.index');

    Route::get('/planes', function () {
        return view('plans.index');
    })->name('plans.index');

    Route::get('/historial', function () {
        return view('history.index');
    })->name('history.index');
});
