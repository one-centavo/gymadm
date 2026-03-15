<?php

use App\Livewire\Auth\RegisterForm;
use App\Livewire\Auth\LoginForm;
use App\Livewire\Dashboard\Index;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('guest')->group(function () {
    Route::get('/login', LoginForm::class)->name('login');
    Route::get('/register', RegisterForm::class)->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Index::class)->name('dashboard');

    Route::post('/logout', function (Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');
});
