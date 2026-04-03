<?php

use App\Livewire\Auth\RecoveryForm;
use App\Livewire\Auth\RegisterForm;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\LoginForm;
use App\Livewire\Dashboard\Index;
use Illuminate\Http\Request;
use App\Livewire\Member\Index as MembersIndex;
use App\Livewire\Plan\Index as MembershipPlansIndex;
use App\Livewire\Membership\Index as MembershipsIndex;

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

    Route::get('/miembros', MembersIndex::class)->name('members.index');

    Route::get('/membresias',MembershipsIndex::class)->name('memberships.index');

    Route::get('/planes', MembershipPlansIndex::class)->name('plans.index');

    Route::get('/historial', function () {
        return view('history.index');
    })->name('history.index');
    Route::get('/members/{member}/manage', function (User $member) {
        return "Gestión del miembro: " . $member->first_name;
    })->name('memberships.manage');
});
