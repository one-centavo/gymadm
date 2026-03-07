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
            return redirect()->route('register.index')
                ->with('error', 'Debes iniciar el registro desde el principio.');
        }

        if (!$request->session()->get('otp_verified', false)) {
            return redirect()->route('register.otp.view')
                ->with('error', 'Aún no has verificado tu identidad con el código.');
        }

        if (!$request->session()->has('registration_profile')) {
            return redirect()->route('register.profile.view')
                ->with('error', 'Por favor, completa tus datos personales.');
        }

        return $next($request);
    }

}
