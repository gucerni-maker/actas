<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use URL;

class ForceSubdirectory
{
    public function handle(Request $request, Closure $next)
    {
        // Forzar que Laravel use la subruta como base
        URL::forceRootUrl(config('app.url'));
        return $next($request);
    }
}
