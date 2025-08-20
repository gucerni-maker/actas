<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Verificar que el usuario esté autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        // Verificar que el usuario esté activo
        if (!auth()->user()->isActivo()) {
            auth()->logout();
            return redirect()->route('login')
                           ->with('error', 'Tu cuenta ha sido desactivada. Contacta al administrador del sistema.');
        }

        $user = auth()->user();
        
        if (in_array($user->rol, $roles)) {
            return $next($request);
        }

        return redirect()->route('dashboard')
                       ->with('error', 'No tienes permisos para acceder a esta sección.');
    }
}