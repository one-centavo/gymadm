<?php

use App\Livewire\Admin\Dashboard\Index as AdminDashboard;
use App\Livewire\Member\Dashboard\Index as MemberDashboard;
use App\Livewire\Admin\Members\Index as MembersIndex;
use App\Livewire\Admin\Memberships\Index as MembershipsIndex;
use App\Livewire\Admin\Plans\Index as MembershipPlansIndex;
use App\Livewire\Admin\History\Index as HistoryIndex;
use App\Livewire\Auth\{LoginForm, RecoveryForm, RegisterForm};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', LoginForm::class)->name('login');
    Route::get('/register', RegisterForm::class)->name('register');
    Route::get('/recovery-account', RecoveryForm::class)->name('recovery-account');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('member.dashboard');
    })->name('dashboard');

    Route::post('/logout', function (Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
        Route::get('/miembros', MembersIndex::class)->name('members.index');
        Route::get('/membresias', MembershipsIndex::class)->name('memberships.index');
        Route::get('/planes', MembershipPlansIndex::class)->name('plans.index');
        Route::get('/historial', HistoryIndex::class)->name('admin.history');
        Route::get('/members/{members}/manage', function ($member) {
            $user = \App\Models\User::findOrFail($member);
            return "Gestión del miembro: " . $user->first_name;
        })->name('memberships.manage');
    });

    Route::middleware('role:member')->prefix('user')->group(function () {
        Route::get('/dashboard', MemberDashboard::class)->name('member.dashboard');
        Route::get('/historial', function () {
            return view('history.index');
        })->name('history.index');
    });

    Route::get('/perfil', function() { return view('profile.edit'); })->name('profile.edit');
});
