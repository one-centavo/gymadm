<?php

use App\Livewire\Auth\RegisterForm;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/register', RegisterForm::class)->name('register');
Route::get('/login', function () {
    return 'Página de Login en construcción';
})->name('login');
