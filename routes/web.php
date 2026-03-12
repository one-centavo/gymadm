<?php

use App\Livewire\Auth\RegisterForm;
use App\Http\Controllers\Auth\LoginController;
use App\Livewire\Dashboard\Index;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/register', RegisterForm::class)->name('register');
//Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
//Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
//Route::get('dashboard', Index::class)->name('dashboard');
