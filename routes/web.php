<?php

use App\Http\Controllers\ActaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgramadorController;
use App\Http\Controllers\ServidorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Ruta para el perfil (temporal)
Route::get('/profile', function () {
    return view('profile.edit');
})->middleware(['auth'])->name('profile.edit');

Route::middleware(['auth'])->group(function () {
    // Rutas para Programadores
    Route::resource('programadores', ProgramadorController::class);
    
    // Rutas para Servidores
    Route::resource('servidores', ServidorController::class);
    
    // Rutas para Actas
    Route::resource('actas', ActaController::class);
});

require __DIR__.'/auth.php';
