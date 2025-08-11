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

        return view('dashboard', compact(
            'totalActas',
            'totalProgramadores',
            'totalServidores',
            'totalAdministradores',
            'totalConsultores',
            'ultimasActas'
        ));
    }
}
