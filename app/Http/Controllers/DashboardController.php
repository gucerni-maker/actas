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
        $ultimasActas = Acta::with(['programador', 'servidor'])
                          ->orderBy('fecha_entrega', 'desc')
                          ->limit(5)
                          ->get();

        // Obtener servidores sin actas asociadas
        $servidoresSinActas = Servidor::whereDoesntHave('actas')
                          ->select('id', 'nombre', 'sistema_operativo', 'tipo')
                          ->limit(10) // Limitar a 10 para no sobrecargar el dashboard
                          ->get();

        // Funcionalidad de búsqueda rápida de actas
        $resultadosBusqueda = collect(); // Colección vacía por defecto
        $terminoBusqueda = '';
        
        if ($request->filled('buscar_rapido')) {
            $terminoBusqueda = $request->get('buscar_rapido');
            
            // Buscar actas por encargado o dirección IP
            $resultadosBusqueda = Acta::with(['programador', 'servidor'])
                                    ->where(function ($query) use ($terminoBusqueda) {
                                        $query->whereHas('programador', function ($q) use ($terminoBusqueda) {
                                            $q->where('nombre', 'LIKE', "%{$terminoBusqueda}%");
                                        })
                                        ->orWhereHas('servidor', function ($q) use ($terminoBusqueda) {
                                            $q->where('nombre', 'LIKE', "%{$terminoBusqueda}%"); // nombre = dirección IP
                                        });
                                    })
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
            'resultadosBusqueda',
            'terminoBusqueda'
        ));
    }
}
