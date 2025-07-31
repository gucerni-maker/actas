<?php

namespace App\Http\Controllers;

use App\Models\Programador;
use Illuminate\Http\Request;

class ProgramadorController extends Controller
{
    public function index()
    {
        $programadores = Programador::paginate(10);
        return view('programadores.index', compact('programadores'));
    }

    public function create()
    {
        return view('programadores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:programadores,correo',
            'cargo' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        Programador::create($request->all());

        return redirect()->route('programadores.index')
                        ->with('success', 'Programador creado exitosamente.');
    }

    public function show(Programador $programador)
    {
        return view('programadores.show', compact('programador'));
    }

    public function edit(Programador $programador)
    {
        return view('programadores.edit', compact('programador'));
    }

    public function update(Request $request, Programador $programador)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:programadores,correo,'.$programador->id,
            'cargo' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        $programador->update($request->all());

        return redirect()->route('programadores.index')
                        ->with('success', 'Programador actualizado exitosamente.');
    }

    public function destroy(Programador $programador)
    {
        $programador->delete();

        return redirect()->route('programadores.index')
                        ->with('success', 'Programador eliminado exitosamente.');
    }
}
