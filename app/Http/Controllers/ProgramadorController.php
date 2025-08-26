<?php

namespace App\Http\Controllers;

use App\Models\Programador;
use Illuminate\Http\Request;

class ProgramadorController extends Controller
{

    public function index(Request $request)
    {
        $this->authorizeRole(['admin', 'consultor']);
        
        $query = Programador::query();
        
        // Filtro de búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%{$buscar}%")
                  ->orWhere('correo', 'LIKE', "%{$buscar}%")
                  ->orWhere('cargo', 'LIKE', "%{$buscar}%")
                  ->orWhere('telefono', 'LIKE', "%{$buscar}%")
                  ->orWhere('codigo_programador', 'LIKE', "%{$buscar}%")
                  ->orWhere('oficina', 'LIKE', "%{$buscar}%")
                  ->orWhere('departamento', 'LIKE', "%{$buscar}%")
                  ->orWhere('rut', 'LIKE', "%{$buscar}%");
            });
        }
        
        // Ordenamiento
        $orden = $request->get('orden', 'nombre');
        $direccion = $request->get('direccion', 'asc');
        $query->orderBy($orden, $direccion);
        
        $programadores = $query->paginate(10)->appends($request->except('page'));
        
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
            'oficina' => 'nullable|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'rut' => 'required|string|max:20|unique:programadores,rut',
            'codigo_programador' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
        ]);

        Programador::create($request->all());

        return redirect()->route('programadores.index')
                        ->with('success', 'Encargado creado exitosamente.');
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
            'oficina' => 'nullable|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'rut' => 'required|string|max:20|unique:programadores,rut,'.$programador->id,
            'codigo_programador' => 'nullable|string|max:20',
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

public function buscarPorRut($rut)
{
    $this->authorizeRole(['admin']);
    
    try {
        // Limpiar el RUT para manejar diferentes formatos
        $rutLimpio = trim($rut);
        
        // Buscar en las tablas de la misma base de datos
        $resultado = \DB::select("
            SELECT 
                r.DESCRIPCION as oficina,
                t.GRADO_DESCRIPCION as cargo_descripcion,
                p.PEFBNOM as nombre,
                p.PEFBCOD as codigo_programador,
                p.PEFBRUT as rut
            FROM pesbasi p
            JOIN tescalafongrado t ON p.PEFBGRA = t.GRADO_CODIGO AND t.ESCALAFON_CODIGO = p.PEFBESC
            JOIN REPARTICION r ON r.ID_CODIGO_VIGENTE = p.PEFBREP
            WHERE p.PEFBRUT = ?
        ", [$rutLimpio]);

        if (!empty($resultado)) {
            $programador = $resultado[0];
            return response()->json([
                'success' => true,
                'programador' => [
                    'nombre' => $programador->nombre,
                    'correo' => '', // Este campo no viene en la consulta, se debe ingresar manualmente
                    'cargo' => $programador->cargo_descripcion,
                    'oficina' => $programador->oficina,
                    'departamento' => '', // Este campo no viene en la consulta
                    'rut' => $programador->rut,
                    'codigo_programador' => $programador->codigo_programador,
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Programador no encontrado en la base de datos'
            ]);
        }
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al buscar el programador: ' . $e->getMessage()
        ]);
    }
}


}
