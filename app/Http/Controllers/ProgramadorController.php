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
        \Log::error('Error al buscar programador por RUT: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error al buscar el programador: ' . $e->getMessage()
        ]);
    }
}


    private function getRutaFirmaAbsoluta($rutaFirmaRelativa)
    {
        // Convertir la ruta relativa a absoluta
        $rutaAbsoluta = storage_path('app/' . $rutaFirmaRelativa);
        
        // Verificar que el archivo exista
        if (file_exists($rutaAbsoluta)) {
            return $rutaAbsoluta;
        }
        
        return null;
    }

    public function vistaPreviaNueva(Request $request)
    {
        $this->authorizeRole(['admin']);

        // Obtener los datos del formulario
        $datos = $request->all();

        // Crear un programador temporal con los datos del formulario
        $programadorTemporal = new \stdClass();
        $programadorTemporal->nombre = $datos['nombre'] ?? 'Programador de Ejemplo';
        $programadorTemporal->correo = $datos['correo'] ?? 'ejemplo@dominio.com';
        $programadorTemporal->cargo = $datos['cargo'] ?? 'Cargo de Ejemplo';
        $programadorTemporal->oficina = $datos['oficina'] ?? 'Oficina de Ejemplo';
        $programadorTemporal->departamento = $datos['departamento'] ?? 'Departamento de Ejemplo';
        $programadorTemporal->rut = $datos['rut'] ?? '12345678-9';
        $programadorTemporal->codigo_programador = $datos['codigo_programador'] ?? 'COD001';
        $programadorTemporal->telefono = $datos['telefono'] ?? '123456789';

        return view('programadores.vista-previa-especial', ['programador' => $programadorTemporal]);
    }

}
