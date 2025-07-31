<?php

namespace App\Http\Controllers;

use App\Models\Acta;
use App\Models\Programador;
use App\Models\Servidor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalActas = Acta::count();
        $totalProgramadores = Programador::count();
        $totalServidores = Servidor::count();
        $ultimasActas = Acta::with(['programador', 'servidor'])
                          ->orderBy('fecha_entrega', 'desc')
                          ->limit(5)
                          ->get();

        return view('dashboard', compact('totalActas', 'totalProgramadores', 'totalServidores', 'ultimasActas'));
    }
}
