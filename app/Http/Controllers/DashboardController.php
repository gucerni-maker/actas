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
        $ultimasActas = Acta::with(['programador', 'servidor', 'usuario'])
                          ->orderBy('fecha_entrega', 'desc')
                          ->limit(5)
                          ->get();

        // Obtener servidores sin actas asociadas
        $servidoresSinActas = Servidor::whereDoesntHave('actas')
                                    ->select('id', 'nombre', 'sistema_operativo', 'tipo')
                                    ->limit(10)
                                    ->get();

        // Obtener actas sin firmar (actas generadas que no han sido firmadas)
        $actasSinFirmar = Acta::with(['programador', 'servidor', 'usuario'])
                            ->where('es_acta_existente', false)  // Solo actas generadas, no existentes
                            ->where('firmada', false)            // Que no estén firmadas
                            ->orderBy('fecha_entrega', 'desc')
                            ->limit(10)
                            ->get();

        $terminoBusqueda = '';

        return view('dashboard', compact(
            'totalActas',
            'totalProgramadores',
            'totalServidores',
            'totalAdministradores',
            'totalConsultores',
            'ultimasActas',
            'servidoresSinActas',
            'actasSinFirmar',
            'terminoBusqueda'  
        ));
    }
}
