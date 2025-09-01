<?php

namespace App\Http\Controllers;

use App\Models\Acta;
use App\Models\Programador;
use App\Models\Servidor;
use App\Models\User;
use App\Models\PlantillaActa;
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
                  ->orWhere('cpu', 'LIKE', "%{$buscar}%")
                  ->orWhere('ram', 'LIKE', "%{$buscar}%")
                  ->orWhere('disco', 'LIKE', "%{$buscar}%")
                  ->orWhere('nombre', 'LIKE', "%{$buscar}%")
                  ->orWhere('notas_tecnicas', 'LIKE', "%{$buscar}%");
            })
            ->orWhere('observaciones', 'LIKE', "%{$buscar}%");
        });
    }
    
    // Ordenamiento
    $orden = $request->get('orden', 'fecha_entrega');
    $direccion = $request->get('direccion', 'desc');
    $query->orderBy($orden, $direccion);
    
    // Configurar paginación a 10 elementos por página
    $actas = $query->paginate(10)->appends($request->except('page'));
    
    $programadores = Programador::all();
    $tiposServidor = ['desarrollo', 'produccion'];
    
    return view('actas.index', compact('actas', 'programadores', 'tiposServidor'));
}


    public function create(Request $request)
    {
        $this->authorizeRole(['admin']);
        
        $programadores = Programador::all();
        $servidores = Servidor::all();
        $plantillas = PlantillaActa::activas()->orderBy('nombre')->get();

        // Si se pasa un servidor_id en la URL, preseleccionarlo
        $servidorSeleccionado = $request->get('servidor_id');

        return view('actas.create', compact('programadores', 'servidores', 'servidorSeleccionado','plantillas'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole(['admin']);
        
            $request->validate([
                'fecha_entrega' => 'required|date',
                'observaciones' => 'nullable|string',
                'archivo_pdf' => 'nullable|file|mimes:pdf|max:10240',
                'programador_id' => 'required|exists:programadores,id',
                'servidor_id' => 'required|exists:servidores,id',
                'comuna' => 'required|string|max:100',
                'oficina_origen' => 'required|string|max:255',
                'oficina_destino' => 'required|string|max:255',
                'texto_introduccion' => 'required|string|max:1000',
                'texto_confidencialidad' => 'required|string',
            ]);

            // Crear el registro de acta
            $data = $request->except('archivo_pdf');
            $data['usuario_id'] = auth()->id();

            // Determinar si es acta existente o generada
            if ($request->hasFile('archivo_pdf')) {
                // Es acta existente
                $data['es_acta_existente'] = true;
                $archivo = $request->file('archivo_pdf');
                $nombreArchivo = 'acta_existente_' . time() . '_' . $archivo->getClientOriginalName();
                $rutaArchivo = $archivo->storeAs('public/actas', $nombreArchivo);
                $data['archivo_pdf'] = str_replace('public/', '', $rutaArchivo);
            } else {
                // Es acta generada (no tiene archivo PDF aún)
                $data['es_acta_existente'] = false;
                $data['archivo_pdf'] = null;
            }

            $acta = Acta::create($data);

            // Si es una acta generada, generar el PDF automáticamente
            if (!$data['es_acta_existente']) {
                $this->generarPDF($acta);
            }
        
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
        
        // Pasar datos adicionales a la vista
        $datosVista = [
            'acta' => $acta,
            'rutaFirmaAbsoluta' => $acta->usuario->ruta_firma ? $this->getRutaFirmaAbsoluta($acta->usuario->ruta_firma) : null
        ];
        
        $pdf = Pdf::loadView('pdf.acta', $datosVista);
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

        // Verificar si es una acta existente cargada
        if ($acta->es_acta_existente && $acta->archivo_pdf) {
            // Si es una acta existente, descargar el archivo PDF cargado
            $rutaArchivo = 'public/' . $acta->archivo_pdf;
            if (Storage::exists($rutaArchivo)) {
                $nombreArchivo = basename($acta->archivo_pdf);
                return Storage::download($rutaArchivo, $nombreArchivo);
            }
        }

        // Si no es una acta existente o el archivo no existe, generar el PDF
        if (!$acta->archivo_pdf) {
            // Si no existe el PDF, lo generamos
            return $this->generarPDF($acta);
        }

        // Verificar si el archivo existe
        if (!Storage::exists('public/' . $acta->archivo_pdf)) {
            // Si no existe el PDF, lo generamos
            return $this->generarPDF($acta);
        }

        // Extraer solo el nombre del archivo para la descarga
        $nombreArchivo = basename($acta->archivo_pdf);
        return Storage::download('public/' . $acta->archivo_pdf, $nombreArchivo);
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

    public function showCargarExistente(Request $request)
    {
       $this->authorizeRole(['admin']);

       $programadores = Programador::all();
       $servidores = Servidor::all();

       // Si se pasa un servidor_id en la URL, preseleccionarlo
       $servidorSeleccionado = $request->get('servidor_id');

       return view('actas.cargar-existente', compact('programadores', 'servidores', 'servidorSeleccionado'));
    }

   public function cargarExistente(Request $request)
   {
       $this->authorizeRole(['admin']);

       $request->validate([
          'fecha_entrega' => 'required|date',
          'observaciones' => 'nullable|string',
          'archivo_pdf' => 'required|file|mimes:pdf|max:10240', // 10MB max
          'programador_id' => 'required|exists:programadores,id',
          'servidor_id' => 'required|exists:servidores,id',
       ]);

       // Guardar el archivo PDF
       $archivo = $request->file('archivo_pdf');
       $nombreArchivo = 'acta_existente_' . time() . '_' . $archivo->getClientOriginalName();
       $rutaArchivo = $archivo->storeAs('public/actas', $nombreArchivo);

       // Crear el registro de acta
       $data = $request->except('archivo_pdf');
       $data['archivo_pdf'] = str_replace('public/', '', $rutaArchivo);
       $data['es_acta_existente'] = true;
       $data['usuario_id'] = auth()->id();

       $acta = Acta::create($data);

       return redirect()->route('actas.index')
           ->with('success', 'Acta existente cargada exitosamente.');
    }

    public function test()
    {
        return response()->json(['message' => 'Test successful']);
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

}
