<?php

use App\Livewire\Auth\{LoginForm, RegisterForm, RecoveryForm};
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Member\Index as MembersIndex;
use App\Livewire\Plan\Index as MembershipPlansIndex;
use App\Livewire\Membership\Index as MembershipsIndex;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', LoginForm::class)->name('login');
    Route::get('/register', RegisterForm::class)->name('register');
    Route::get('/recovery-account', RecoveryForm::class)->name('recovery-account');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', DashboardIndex::class)->name('dashboard');

    Route::post('/logout', function (Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/miembros', MembersIndex::class)->name('members.index');
        Route::get('/membresias', MembershipsIndex::class)->name('memberships.index');
        Route::get('/planes', MembershipPlansIndex::class)->name('plans.index');

        Route::get('/members/{members}/manage', function ($member) {
            $user = \App\Models\User::findOrFail($member);
            return "Gestión del miembro: " . $user->first_name;
        })->name('memberships.manage');
    });

    Route::middleware('role:members')->prefix('user')->group(function () {
        Route::get('/historial', function () {
            return view('history.index');
        })->name('history.index');
    });

    Route::get('/perfil', function() { return view('profile.edit'); })->name('profile.edit');
});
