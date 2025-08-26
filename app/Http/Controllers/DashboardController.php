<?php

namespace App\Http\Controllers;

use App\Models\Acta;
use App\Models\Programador;
use App\Models\Servidor;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
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

        return view('dashboard', compact(
            'totalActas',
            'totalProgramadores',
            'totalServidores',
            'totalAdministradores',
            'totalConsultores',
            'ultimasActas',
            'servidoresSinActas'
        ));
    }
}
