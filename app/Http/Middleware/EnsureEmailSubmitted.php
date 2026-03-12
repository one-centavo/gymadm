<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailSubmitted
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->session()->has('email')){
            return redirect()->route('register')
                ->with('error', 'Por favor, ingresa tu correo electrónico para comenzar.');
        }
        return $next($request);
    }
}
