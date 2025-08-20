<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckConsultor
{
    public function handle(Request $request, Closure $next): Response
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
        
        // Verificar que el usuario tenga rol de consultor o administrador
        if (auth()->user()->rol !== 'consultor' && auth()->user()->rol !== 'admin') {
            return redirect()->route('dashboard')
                           ->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}