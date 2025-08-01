<?php

namespace App\Http\Controllers;

use App\Models\Programador;
use Illuminate\Http\Request;

class ProgramadorController extends Controller
{
    public function index()
    {
        $this->authorizeRole(['admin', 'consultor']);
        $programadores = Programador::paginate(10);
        return view('programadores.index', compact('programadores'));
    }

    public function create()
    {
        $this->authorizeRole(['admin']);
        return view('programadores.create');
    }

    public function store(Request $request)
    {
        $this->authorizeRole(['admin']);
        
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
        $this->authorizeRole(['admin', 'consultor']);
        return view('programadores.show', compact('programador'));
    }

    public function edit(Programador $programador)
    {
        $this->authorizeRole(['admin']);
        return view('programadores.edit', compact('programador'));
    }

    public function update(Request $request, Programador $programador)
    {
        $this->authorizeRole(['admin']);
        
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
        $this->authorizeRole(['admin']);
        
        $programador->delete();

        return redirect()->route('programadores.index')
                        ->with('success', 'Programador eliminado exitosamente.');
    }
    
    private function authorizeRole($allowedRoles)
    {
        if (!auth()->check()) {
            abort(401);
        }
        
        $userRole = auth()->user()->rol;
        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
    }
}
