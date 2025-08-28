<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (TokenMismatchException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Token expired. Please login again.'], 419);
            }
            
            // Para peticiones normales, redirigir al login
            return redirect()->route('login')
                           ->with('error', 'Su sesión ha expirado. Por favor, inicie sesión nuevamente.')
                           ->withInput();
        });
        
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
