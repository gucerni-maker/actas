<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServidorController extends Controller
{

    public function index(Request $request)
    {
        //$this->authorizeRole(['admin', 'consultor']);
        
        $query = Servidor::query();
        
        // Filtro de búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%{$buscar}%")
                  ->orWhere('sistema_operativo', 'LIKE', "%{$buscar}%")
                  ->orWhere('cpu', 'LIKE', "%{$buscar}%")
                  ->orWhere('ram', 'LIKE', "%{$buscar}%")
                  ->orWhere('disco', 'LIKE', "%{$buscar}%")
                  ->orWhere('notas_tecnicas', 'LIKE', "%{$buscar}%")
                  ->orWhere('tipo', 'LIKE', "%{$buscar}%");
            });
        }
        
        // Ordenamiento
        $orden = $request->get('orden', 'nombre');
        $direccion = $request->get('direccion', 'asc');
        $query->orderBy($orden, $direccion);
        
        $servidores = $query->paginate(10)->appends($request->except('page'));
        
        return view('servidores.index', compact('servidores'));
    }

    public function create()
    {
        //$this->authorizeRole(['admin']);
        return view('servidores.create');
    }

    public function store(Request $request)
    {
        //$this->authorizeRole(['admin']);
        
        $request->validate([
            'nombre' => [
            'required', 
            'string', 
            'max:255',            
            'unique:servidores,nombre'
            ],
            'notas_tecnicas' => 'nullable|string',
            'tipo' => 'required|in:desarrollo,produccion',
            'sistema_operativo' => 'required|string|max:255',
            'cpu' => 'required|string|max:255',
            'ram' => 'required|string|max:50',
            'disco' => 'required|string|max:255',
            'notas_tecnicas' => 'nullable|string',
        ],[
        // Mensajes de error personalizados
        'nombre.unique' => 'Ya existe un servidor con esta dirección IP. Por favor, ingrese una dirección IP única.',
        'nombre.required' => 'La dirección IP es obligatoria.',
        'nombre.max' => 'La dirección IP no debe exceder los 255 caracteres.',
        'tipo.required' => 'El tipo de servidor es obligatorio.',
        'tipo.in' => 'El tipo de servidor debe ser desarrollo o producción.',
        'sistema_operativo.required' => 'El sistema operativo es obligatorio.',
        'sistema_operativo.max' => 'El sistema operativo no debe exceder los 255 caracteres.',
        'cpu.required' => 'La CPU es obligatoria.',
        'cpu.max' => 'La CPU no debe exceder los 255 caracteres.',
        'ram.required' => 'La RAM es obligatoria.',
        'ram.max' => 'La RAM no debe exceder los 255 caracteres.',
        'disco.required' => 'El disco es obligatorio.',
        'disco.max' => 'El disco no debe exceder los 255 caracteres.',
        ]);

        Servidor::create($request->all());

        return redirect()->route('servidores.index')
                        ->with('success', 'Servidor creado exitosamente.');
    }

    public function show(Servidor $servidor)
    {
        //$this->authorizeRole(['admin', 'consultor']);
        return view('servidores.show', compact('servidor'));
    }

    public function edit(Servidor $servidor)
    {
        //$this->authorizeRole(['admin']);
        return view('servidores.edit', compact('servidor'));
    }

    public function update(Request $request, Servidor $servidor)
    {
        //$this->authorizeRole(['admin']);
        
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
        //$this->authorizeRole(['admin']);
        
        $servidor->delete();

        return redirect()->route('servidores.index')
                        ->with('success', 'Servidor eliminado exitosamente.');
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
