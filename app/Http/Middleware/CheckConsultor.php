<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckConsultor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->rol !== 'consultor' && auth()->user()->rol !== 'admin') {
            return redirect()->route('dashboard')
                           ->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
