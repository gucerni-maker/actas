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

// Rutas para todos los usuarios autenticados
Route::middleware(['auth'])->group(function () {
    Route::resource('programadores', ProgramadorController::class)->parameters(['programadores' => 'programador']);
    Route::resource('servidores', ServidorController::class)->parameters(['servidores' => 'servidor']);
    Route::resource('actas', ActaController::class)->parameters(['actas' => 'acta']);
    Route::get('actas/{acta}/pdf', [ActaController::class, 'descargarPDF'])->name('actas.pdf');
});

require __DIR__.'/auth.php';
