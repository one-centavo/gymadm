<?php
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


//****** Registration Routes ******

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'index')->name('register');
    Route::post('/register', 'sendOtp')->name('register.sendOtp');

    Route::middleware(['ensure.email.submitted'])->group(function () {
        Route::get('/verify-otp', 'showOtpForm')->name('register.verifyOtp');
        Route::post('/verify-otp', 'verifyOtp')->name('register.verifyOtp.post');
    });

    Route::middleware(['ensure.otp.verified'])->group(function () {
        Route::get('/register-form', 'showRegistrationForm')->name('register.form');
    });

    Route::post('/register-form', 'registerMember')->middleware('ensure.registration.complete')->name('register.post');
});
