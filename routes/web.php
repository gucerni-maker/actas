<?php

use App\Http\Controllers\ActaController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgramadorController;
use App\Http\Controllers\ServidorController;
use App\Http\Controllers\PlantillaActaController;
use Illuminate\Support\Facades\Route;

// Ruta principal que va directamente al dashboard
Route::get('/', function () {
    $totalActas = \App\Models\Acta::count();
    $totalProgramadores = \App\Models\Programador::count();
    $totalServidores = \App\Models\Servidor::count();
    $totalAdministradores = \App\Models\User::where('rol', 'admin')->count();
    $totalConsultores = \App\Models\User::where('rol', 'consultor')->count();
    
    // Obtener las últimas actas
    $ultimasActas = \App\Models\Acta::with(['programador', 'servidor', 'usuario'])
                              ->orderBy('fecha_entrega', 'desc')
                              ->limit(5)
                              ->get();
    
    // Obtener servidores sin actas asociadas
    $servidoresSinActas = \App\Models\Servidor::whereDoesntHave('actas')
                                        ->select('id', 'nombre', 'sistema_operativo', 'tipo')
                                        ->limit(10)
                                        ->get();
    
    // Obtener actas sin firmar
    $actasSinFirmar = \App\Models\Acta::with(['programador', 'servidor', 'usuario'])
                                ->where('es_acta_existente', false)
                                ->where('firmada', false)
                                ->orderBy('fecha_entrega', 'desc')
                                ->limit(10)
                                ->get();

    $terminoBusqueda = '';
    $resultadosBusqueda = collect();

    return view('dashboard', compact(
        'totalActas',
        'totalProgramadores',
        'totalServidores',
        'totalAdministradores',
        'totalConsultores',
        'ultimasActas',
        'servidoresSinActas',
        'actasSinFirmar',
        'terminoBusqueda',
        'resultadosBusqueda'
    ));
});

// Ruta para el dashboard
Route::get('/dashboard', function () {
    $totalActas = \App\Models\Acta::count();
    $totalProgramadores = \App\Models\Programador::count();
    $totalServidores = \App\Models\Servidor::count();
    $totalAdministradores = \App\Models\User::where('rol', 'admin')->count();
    $totalConsultores = \App\Models\User::where('rol', 'consultor')->count();
    
    // Obtener las últimas actas
    $ultimasActas = \App\Models\Acta::with(['programador', 'servidor', 'usuario'])
                              ->orderBy('fecha_entrega', 'desc')
                              ->limit(5)
                              ->get();
    
    // Obtener servidores sin actas asociadas
    $servidoresSinActas = \App\Models\Servidor::whereDoesntHave('actas')
                                        ->select('id', 'nombre', 'sistema_operativo', 'tipo')
                                        ->limit(10)
                                        ->get();
    
    // Obtener actas sin firmar
    $actasSinFirmar = \App\Models\Acta::with(['programador', 'servidor', 'usuario'])
                                ->where('es_acta_existente', false)
                                ->where('firmada', false)
                                ->orderBy('fecha_entrega', 'desc')
                                ->limit(10)
                                ->get();

    $terminoBusqueda = '';
    $resultadosBusqueda = collect();

    return view('dashboard', compact(
        'totalActas',
        'totalProgramadores',
        'totalServidores',
        'totalAdministradores',
        'totalConsultores',
        'ultimasActas',
        'servidoresSinActas',
        'actasSinFirmar',
        'terminoBusqueda',
        'resultadosBusqueda'
    ));
})->name('dashboard');

// Rutas públicas para ver datos
Route::get('actas', [ActaController::class, 'index'])->name('actas.index');
Route::get('actas/{acta}', [ActaController::class, 'show'])->name('actas.show');
Route::get('actas/{acta}/pdf', [ActaController::class, 'descargarPDF'])->name('actas.pdf');

Route::get('programadores', [ProgramadorController::class, 'index'])->name('programadores.index');
Route::get('programadores/{programador}', [ProgramadorController::class, 'show'])->name('programadores.show');

Route::get('servidores', [ServidorController::class, 'index'])->name('servidores.index');
Route::get('servidores/{servidor}', [ServidorController::class, 'show'])->name('servidores.show');

// Ruta para buscar programadores por RUT (simplificada para demostración)
Route::get('buscar-programador/{rut}', [ProgramadorController::class, 'buscarPorRutDemo'])->name('programadores.buscar-por-rut-demo');

Route::get('test-acta', [ActaController::class, 'test']);
Route::get('prueba-cargar', [ActaController::class, 'showCargarExistente']);

// Eliminar todas las rutas protegidas con middleware 'auth'

// Rutas de plantillas (solo lectura para demostración)
Route::get('plantillas', [PlantillaActaController::class, 'index'])->name('plantillas.index');
Route::get('plantillas/{plantilla}', [PlantillaActaController::class, 'show'])->name('plantillas.show');
Route::get('plantillas/{plantilla}/vista-previa-pdf', [PlantillaActaController::class, 'preview'])->name('plantillas.vista-previa-pdf');

// Ruta para obtener datos de plantilla
Route::get('plantillas/{plantilla}/datos', [PlantillaActaController::class, 'getDatosPlantilla'])->name('plantillas.datos');

// Si hay rutas específicas que necesitas proteger, puedes comentarlas
// Route::resource('programadores', ProgramadorController::class)->parameters(['programadores' => 'programador']); // Comentada
// Route::resource('servidores', ServidorController::class)->parameters(['servidores' => 'servidor']); // Comentada
// Route::resource('actas', ActaController::class)->parameters(['actas' => 'acta']); // Comentada