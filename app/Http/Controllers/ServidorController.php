<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use Illuminate\Http\Request;

class ServidorController extends Controller
{
    public function index()
    {
        $servidores = Servidor::paginate(10);
        return view('servidores.index', compact('servidores'));
    }

    public function create()
    {
        return view('servidores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:desarrollo,produccion',
            'sistema_operativo' => 'required|string|max:255',
            'cpu' => 'required|string|max:255',
            'ram' => 'required|string|max:50',
            'disco' => 'required|string|max:255',
            'notas_tecnicas' => 'nullable|string',
        ]);

        Servidor::create($request->all());

        return redirect()->route('servidores.index')
                        ->with('success', 'Servidor creado exitosamente.');
    }

    public function show(Servidor $servidor)
    {
        return view('servidores.show', compact('servidor'));
    }

    public function edit(Servidor $servidor)
    {
        return view('servidores.edit', compact('servidor'));
    }

    public function update(Request $request, Servidor $servidor)
    {
        $request->validate([
            'tipo' => 'required|in:desarrollo,produccion',
            'sistema_operativo' => 'required|string|max:255',
            'cpu' => 'required|string|max:255',
            'ram' => 'required|string|max:50',
            'disco' => 'required|string|max:255',
            'notas_tecnicas' => 'nullable|string',
        ]);

        $servidor->update($request->all());

        return redirect()->route('servidores.index')
                        ->with('success', 'Servidor actualizado exitosamente.');
    }

    public function destroy(Servidor $servidor)
    {
        $servidor->delete();

        return redirect()->route('servidores.index')
                        ->with('success', 'Servidor eliminado exitosamente.');
    }
}
