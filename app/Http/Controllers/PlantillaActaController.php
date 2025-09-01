<?php

namespace App\Http\Controllers;

use App\Models\PlantillaActa;
use Illuminate\Http\Request;

class PlantillaActaController extends Controller
{
    
    public function index()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        $plantillas = PlantillaActa::orderBy('nombre')->paginate(10);
        return view('plantillas.index', compact('plantillas'));
    }

    public function create()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        return view('plantillas.create');
    }

    public function store(Request $request)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
        abort(403, 'No tienes permisos para acceder a esta sección.');
    }
    
    $request->validate([
        'nombre' => 'required|string|max:255',
        'texto_introduccion' => 'nullable|string',
        'texto_confidencialidad' => 'nullable|string',
        'encabezado_personalizado' => 'nullable|string',
        'pie_personalizado' => 'nullable|string',
        // Simplificar la validación de activa
        'activa' => 'nullable|in:on,1,true,0,false',
    ]);

    $data = $request->except('activa');
    // Convertir el valor del checkbox a booleano
    $data['activa'] = $request->has('activa') && in_array($request->activa, ['on', '1', 'true']);

    PlantillaActa::create($data);

    return redirect()->route('plantillas.index')
                    ->with('success', 'Plantilla creada exitosamente.');
    }

    public function show(PlantillaActa $plantilla)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        return view('plantillas.show', compact('plantilla'));
    }

    public function edit(PlantillaActa $plantilla)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        return view('plantillas.edit', compact('plantilla'));
    }

    public function update(Request $request, PlantillaActa $plantilla)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
        abort(403, 'No tienes permisos para acceder a esta sección.');
    }
    
    $request->validate([
        'nombre' => 'required|string|max:255',
        'texto_introduccion' => 'nullable|string',
        'texto_confidencialidad' => 'nullable|string',
        'encabezado_personalizado' => 'nullable|string',
        'pie_personalizado' => 'nullable|string',
        // Simplificar la validación de activa
        'activa' => 'nullable|in:on,1,true,0,false',
    ]);

    $data = $request->except('activa');
    // Convertir el valor del checkbox a booleano
    $data['activa'] = $request->has('activa') && in_array($request->activa, ['on', '1', 'true']);

    $plantilla->update($data);

    return redirect()->route('plantillas.index')
                    ->with('success', 'Plantilla actualizada exitosamente.');
    }

    public function destroy(PlantillaActa $plantilla)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        $plantilla->delete();

        return redirect()->route('plantillas.index')
                        ->with('success', 'Plantilla eliminada exitosamente.');
    }

    // Método para obtener plantillas activas por tipo (para usar en AJAX)
    public function getActivasPorTipo($tipo)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        $plantillas = PlantillaActa::activas()
                                 ->porTipo($tipo)
                                 ->select('id', 'nombre')
                                 ->get();

        return response()->json([
            'success' => true,
            'plantillas' => $plantillas
        ]);
    }

    public function getDatosPlantilla(PlantillaActa $plantilla)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        return response()->json([
            'success' => true,
            'plantilla' => [
                'id' => $plantilla->id,
                'nombre' => $plantilla->nombre,
                'texto_introduccion' => $plantilla->texto_introduccion,
                'texto_confidencialidad' => $plantilla->texto_confidencialidad,
                'encabezado_personalizado' => $plantilla->encabezado_personalizado,
                'pie_personalizado' => $plantilla->pie_personalizado,
            ]
        ]);
    }

    public function preview(PlantillaActa $plantilla)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        return view('plantillas.vista-previa-pdf', compact('plantilla'));
    }

public function vistaPreviaTemporal()
{
    if (!auth()->check() || !auth()->user()->isAdmin()) {
        abort(403, 'No tienes permisos para acceder a esta sección.');
    }
    
    // Crear una plantilla temporal con datos reales de prueba
    $plantillaTemporal = new \stdClass();
    $plantillaTemporal->nombre = 'Plantilla de Prueba Real';
    $plantillaTemporal->tipo = 'desarrollo';
    $plantillaTemporal->texto_introduccion = 'La oficina de Aplicaciones y Base de Datos hace entrega de la base de datos del sistema XXXXX, el cual será entregado mediante un archivo .sql al funcionario que firma la presente acta.';
    $plantillaTemporal->texto_confidencialidad = 'Se hace presente la confidencialidad que se debe tener sobre la información que se hace entrega y el resguardo de la misma. Atendido a lo dispuesto en la Ley N° 21459 relativa a delitos informáticos, Ley No 19.628 sobre protección de la vida privada o protección de datos de carácter personal, Ley 20.285 acceso a la información pública y Artículo 436 código justicia militar.';
    $plantillaTemporal->encabezado_personalizado = '';
    $plantillaTemporal->pie_personalizado = '';
    $plantillaTemporal->activa = true;
    
    return view('plantillas.vista-previa-pdf', ['plantilla' => $plantillaTemporal]);
}



    public function vistaPreviaTiempoReal(Request $request)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        // Crear una plantilla temporal con los datos del formulario
        $plantillaTemporal = new \stdClass();
        $plantillaTemporal->nombre = $request->nombre ?? 'Plantilla de Ejemplo';
        $plantillaTemporal->tipo = $request->tipo ?? 'desarrollo';
        $plantillaTemporal->texto_introduccion = $request->texto_introduccion ?? 'Texto introductorio de ejemplo...';
        $plantillaTemporal->texto_confidencialidad = $request->texto_confidencialidad ?? 'Texto de confidencialidad de ejemplo...';
        $plantillaTemporal->encabezado_personalizado = $request->encabezado_personalizado ?? '';
        $plantillaTemporal->pie_personalizado = $request->pie_personalizado ?? '';
        $plantillaTemporal->activa = $request->has('activa') && in_array($request->activa, ['on', '1', 'true']) ? true : false;

        // Crear un usuario temporal para la vista previa
        $usuarioTemporal = new \stdClass();
        $usuarioTemporal->name = auth()->user()->name;
        $usuarioTemporal->cargo = auth()->user()->cargo ?? 'ADMINISTRADOR DE SISTEMAS';
        $usuarioTemporal->ruta_firma = auth()->user()->ruta_firma;

        return view('plantillas.vista-previa-pdf', [
            'plantilla' => $plantillaTemporal,
            'usuario' => $usuarioTemporal
        ]);
    }

}