<?php

namespace App\Http\Controllers;

use App\Models\Acta;
use App\Models\Programador;
use App\Models\Servidor;
use App\Models\User;
use Illuminate\Http\Request;

class ActaController extends Controller
{
    public function index()
    {
        $actas = Acta::with(['programador', 'servidor', 'usuario'])
                    ->orderBy('fecha_entrega', 'desc')
                    ->paginate(10);
        return view('actas.index', compact('actas'));
    }

    public function create()
    {
        $programadores = Programador::all();
        $servidores = Servidor::all();
        return view('actas.create', compact('programadores', 'servidores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_entrega' => 'required|date',
            'observaciones' => 'nullable|string',
            'programador_id' => 'required|exists:programadores,id',
            'servidor_id' => 'required|exists:servidores,id',
        ]);

        $data = $request->all();
        $data['usuario_id'] = auth()->id();

        Acta::create($data);

        return redirect()->route('actas.index')
                        ->with('success', 'Acta creada exitosamente.');
    }

    public function show(Acta $acta)
    {
        $acta->load(['programador', 'servidor', 'usuario']);
        return view('actas.show', compact('acta'));
    }

    public function edit(Acta $acta)
    {
        $programadores = Programador::all();
        $servidores = Servidor::all();
        return view('actas.edit', compact('acta', 'programadores', 'servidores'));
    }

    public function update(Request $request, Acta $acta)
    {
        $request->validate([
            'fecha_entrega' => 'required|date',
            'observaciones' => 'nullable|string',
            'programador_id' => 'required|exists:programadores,id',
            'servidor_id' => 'required|exists:servidores,id',
        ]);

        $acta->update($request->except('usuario_id'));

        return redirect()->route('actas.index')
                        ->with('success', 'Acta actualizada exitosamente.');
    }

    public function destroy(Acta $acta)
    {
        $acta->delete();

        return redirect()->route('actas.index')
                        ->with('success', 'Acta eliminada exitosamente.');
    }
}
