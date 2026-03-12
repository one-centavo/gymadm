<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!request()->session()->has('email') || !request()->session()->has('verified_otp')){
            return redirect()->route('register.index')
                ->with('error', 'Por favor, ingresa tu correo electrónico para comenzar.');
        }
        return $next($request);
    }
}
