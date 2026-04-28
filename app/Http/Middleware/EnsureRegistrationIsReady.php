<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRegistrationIsReady{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('email')) {
            return redirect()->route('register')
                ->with('error', 'You should start the registration process by submitting your email.');
        }

        if (!$request->session()->get('verified_otp', false)) {
            return redirect()->route('register.verifyOtp')
                ->with('error', 'Please verify the OTP sent to your email before proceeding with registration.');
        }

        return $next($request);
    }
}
