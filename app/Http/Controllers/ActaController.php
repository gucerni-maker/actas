<?php

namespace App\Http\Controllers;

use App\Models\Acta;
use App\Models\Programador;
use App\Models\Servidor;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ActaController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeRole(['admin', 'consultor']);
        
        $query = Acta::with(['programador', 'servidor', 'usuario']);
        
        // Filtros
        if ($request->filled('fecha_desde')) {
            $query->where('fecha_entrega', '>=', $request->fecha_desde);
        }
        
        if ($request->filled('fecha_hasta')) {
            $query->where('fecha_entrega', '<=', $request->fecha_hasta);
        }
        
        if ($request->filled('programador_id')) {
            $query->where('programador_id', $request->programador_id);
        }
        
        if ($request->filled('servidor_tipo')) {
            $query->whereHas('servidor', function ($q) use ($request) {
                $q->where('tipo', $request->servidor_tipo);
            });
        }
        
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->whereHas('programador', function ($qp) use ($buscar) {
                    $qp->where('nombre', 'LIKE', "%{$buscar}%")
                      ->orWhere('correo', 'LIKE', "%{$buscar}%");
                })
                ->orWhereHas('servidor', function ($qs) use ($buscar) {
                    $qs->where('sistema_operativo', 'LIKE', "%{$buscar}%")
                      ->orWhere('cpu', 'LIKE', "%{$buscar}%");
                });
            });
        }
        
        // Ordenamiento
        $orden = $request->get('orden', 'fecha_entrega');
        $direccion = $request->get('direccion', 'desc');
        $query->orderBy($orden, $direccion);
        
        $actas = $query->paginate(10)->appends($request->except('page'));
        
        $programadores = Programador::all();
        $tiposServidor = ['desarrollo', 'produccion'];
        
        return view('actas.index', compact('actas', 'programadores', 'tiposServidor'));
    }

    public function create()
    {
        $this->authorizeRole(['admin']);
        
        $programadores = Programador::all();
        $servidores = Servidor::all();
        return view('actas.create', compact('programadores', 'servidores'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole(['admin']);
        
        $request->validate([
            'fecha_entrega' => 'required|date',
            'observaciones' => 'nullable|string',
            'programador_id' => 'required|exists:programadores,id',
            'servidor_id' => 'required|exists:servidores,id',
        ]);

        $data = $request->all();
        $data['usuario_id'] = auth()->id();

        $acta = Acta::create($data);

        // Generar PDF automáticamente al crear la acta
        $this->generarPDF($acta);

        return redirect()->route('actas.index')
                        ->with('success', 'Acta creada exitosamente.');
    }

    public function show(Acta $acta)
    {
        $this->authorizeRole(['admin', 'consultor']);
        
        $acta->load(['programador', 'servidor', 'usuario']);
        return view('actas.show', compact('acta'));
    }

    public function edit(Acta $acta)
    {
        $this->authorizeRole(['admin']);
        
        $programadores = Programador::all();
        $servidores = Servidor::all();
        return view('actas.edit', compact('acta', 'programadores', 'servidores'));
    }

    public function update(Request $request, Acta $acta)
    {
        $this->authorizeRole(['admin']);
        
        $request->validate([
            'fecha_entrega' => 'required|date',
            'observaciones' => 'nullable|string',
            'programador_id' => 'required|exists:programadores,id',
            'servidor_id' => 'required|exists:servidores,id',
        ]);

        $acta->update($request->except('usuario_id'));

        // Regenerar PDF si se actualiza la acta
        $this->generarPDF($acta);

        return redirect()->route('actas.index')
                        ->with('success', 'Acta actualizada exitosamente.');
    }

    public function destroy(Acta $acta)
    {
        $this->authorizeRole(['admin']);
        
        // Eliminar PDF si existe
        if ($acta->archivo_pdf && Storage::exists($acta->archivo_pdf)) {
            Storage::delete($acta->archivo_pdf);
        }

        $acta->delete();

        return redirect()->route('actas.index')
                        ->with('success', 'Acta eliminada exitosamente.');
    }

    public function generarPDF(Acta $acta)
    {
        $this->authorizeRole(['admin', 'consultor']);
        
        $acta->load(['programador', 'servidor', 'usuario']);
        
        $pdf = Pdf::loadView('pdf.acta', compact('acta'));
        $pdf->setPaper('A4');
        
        // Nombre del archivo
        $nombreArchivo = 'acta_entrega_' . $acta->id . '_' . now()->format('YmdHis') . '.pdf';
        
        // Guardar el PDF en storage
        $rutaArchivo = 'public/actas/' . $nombreArchivo;
        Storage::put($rutaArchivo, $pdf->output());
        
        // Actualizar la ruta del archivo en la base de datos
        $acta->update(['archivo_pdf' => $rutaArchivo]);
        
        return $pdf->download($nombreArchivo);
    }

    public function descargarPDF(Acta $acta)
    {
        $this->authorizeRole(['admin', 'consultor']);
        
        if (!$acta->archivo_pdf) {
            // Si no existe el PDF, lo generamos
            return $this->generarPDF($acta);
        }
        
        // Verificar si el archivo existe
        if (!Storage::exists($acta->archivo_pdf)) {
            // Si no existe el PDF, lo generamos
            return $this->generarPDF($acta);
        }
        
        // Extraer solo el nombre del archivo para la descarga
        $nombreArchivo = basename($acta->archivo_pdf);
        return Storage::download($acta->archivo_pdf, $nombreArchivo);
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
