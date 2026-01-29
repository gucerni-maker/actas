<?php

namespace App\Http\Controllers;

use App\Models\Acta;
use App\Models\Programador;
use App\Models\Servidor;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalActas = Acta::count();
        $totalProgramadores = Programador::count();
        $totalServidores = Servidor::count();
        
        // Agregar conteo de usuarios por rol
        $totalAdministradores = User::where('rol', 'admin')->count();
        $totalConsultores = User::where('rol', 'consultor')->count();
        
        // Obtener las últimas actas
        $ultimasActas = Acta::with(['programador', 'servidor', 'usuario'])
                          ->orderBy('fecha_entrega', 'desc')
                          ->limit(5)
                          ->get();
        
        // Obtener servidores sin actas asociadas
        $servidoresSinActas = Servidor::whereDoesntHave('actas')
                                    ->select('id', 'nombre', 'sistema_operativo', 'tipo')
                                    ->limit(10)
                                    ->get();
        
        // Obtener actas sin firmar
        $actasSinFirmar = Acta::with(['programador', 'servidor', 'usuario'])
                            ->where('es_acta_existente', false)
                            ->where('firmada', false)
                            ->orderBy('fecha_entrega', 'desc')
                            ->limit(10)
                            ->get();
        
        // Variables para la búsqueda
        $terminoBusqueda = '';
        $resultadosBusqueda = collect(); // Colección vacía por defecto
        
        // Lógica de búsqueda rápida
        if ($request->filled('buscar_rapido')) {
            $terminoBusqueda = $request->get('buscar_rapido');
            
            // Buscar actas por encargado o servidor
            $resultadosBusqueda = Acta::with(['programador', 'servidor', 'usuario'])
                                    ->where(function ($query) use ($terminoBusqueda) {
                                        $query->whereHas('programador', function ($q) use ($terminoBusqueda) {
                                            $q->where('nombre', 'LIKE', "%{$terminoBusqueda}%")
                                              ->orWhere('correo', 'LIKE', "%{$terminoBusqueda}%")
                                              ->orWhere('cargo', 'LIKE', "%{$terminoBusqueda}%")
                                              ->orWhere('oficina', 'LIKE', "%{$terminoBusqueda}%")
                                              ->orWhere('departamento', 'LIKE', "%{$terminoBusqueda}%")
                                              ->orWhere('rut', 'LIKE', "%{$terminoBusqueda}%")
                                              ->orWhere('codigo_programador', 'LIKE', "%{$terminoBusqueda}%")
                                              ->orWhere('telefono', 'LIKE', "%{$terminoBusqueda}%");
                                        })
                                        ->orWhereHas('servidor', function ($q) use ($terminoBusqueda) {
                                            $q->where('nombre', 'LIKE', "%{$terminoBusqueda}%")
                                              ->orWhere('sistema_operativo', 'LIKE', "%{$terminoBusqueda}%")
                                              ->orWhere('cpu', 'LIKE', "%{$terminoBusqueda}%")
                                              ->orWhere('ram', 'LIKE', "%{$terminoBusqueda}%")
                                              ->orWhere('disco', 'LIKE', "%{$terminoBusqueda}%")
                                              ->orWhere('notas_tecnicas', 'LIKE', "%{$terminoBusqueda}%");
                                        })
                                        ->orWhere('observaciones', 'LIKE', "%{$terminoBusqueda}%");
                                    })
                                    ->orderBy('fecha_entrega', 'desc')
                                    ->limit(10)
                                    ->get();
        }

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
    }
}