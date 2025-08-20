<?php

use App\Http\Controllers\ActaController;
use App\Http\Controllers\AdminUserController;
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

// Rutas específicas de actas (colocarlas antes de resource)
Route::get('actas/cargar-existente', [ActaController::class, 'showCargarExistente'])->name('actas.cargar-existente.form');
Route::post('actas/cargar-existente', [ActaController::class, 'cargarExistente'])->name('actas.cargar-existente');
Route::get('actas/{acta}/pdf', [ActaController::class, 'descargarPDF'])->name('actas.pdf');
Route::get('programadores/buscar-por-rut/{rut}', [ProgramadorController::class, 'buscarPorRut'])->name('programadores.buscar-por-rut');


// Rutas para todos los usuarios autenticados
Route::middleware(['auth'])->group(function () {
    Route::resource('programadores', ProgramadorController::class)->parameters(['programadores' => 'programador']);
    Route::resource('servidores', ServidorController::class)->parameters(['servidores' => 'servidor']);
    Route::resource('actas', ActaController::class)->parameters(['actas' => 'acta']);
});

Route::get('test-acta', [ActaController::class, 'test']);
Route::get('prueba-cargar', [ActaController::class, 'showCargarExistente']);

// Ruta especial para que administradores registren nuevos usuarios
Route::get('/admin/register', function () {
    // Verificar que el usuario sea administrador
    if (!auth()->check() || !auth()->user()->isAdmin()) {
        abort(403, 'No tienes permisos para acceder a esta sección.');
    }
    return view('auth.register-admin');
})->name('admin.register')->middleware('auth');

// Ruta para buscar programadores por RUT en el registro de usuarios
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/usuarios/buscar-por-rut/{rut}', [App\Http\Controllers\AdminUserController::class, 'buscarPorRut'])->name('admin.usuarios.buscar-por-rut');
});

// Ruta especial para que administradores registren nuevos usuarios
Route::post('/admin/register', [App\Http\Controllers\AdminUserController::class, 'store'])->name('admin.register.store')->middleware('auth');

// Rutas para gestión de usuarios (solo administradores)
Route::middleware('auth')->group(function () {
    Route::get('users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    Route::put('users/{user}/change-password', [App\Http\Controllers\UserController::class, 'changePassword'])->name('users.change-password');
});

// Rutas para filtrar usuarios por rol
Route::middleware('auth')->group(function () {
    Route::get('users/administradores', [App\Http\Controllers\UserController::class, 'administradores'])->name('users.administradores');
    Route::get('users/consultores', [App\Http\Controllers\UserController::class, 'consultores'])->name('users.consultores');
});

// Rutas para gestión de usuarios (solo administradores)
Route::middleware('auth')->group(function () {
    Route::get('users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    Route::put('users/{user}/change-password', [App\Http\Controllers\UserController::class, 'changePassword'])->name('users.change-password');
    Route::put('users/{user}/reactivar', [App\Http\Controllers\UserController::class, 'reactivar'])->name('users.reactivar');
});

require __DIR__.'/auth.php';
