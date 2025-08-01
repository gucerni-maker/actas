<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        if (in_array($user->rol, $roles)) {
            return $next($request);
        }

        return redirect()->route('dashboard')
                       ->with('error', 'No tienes permisos para acceder a esta sección.');
    }
}
