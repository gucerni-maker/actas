@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Vista Previa de la Plantilla</h5>
                    <a href="{{ route('plantillas.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <div class="preview-container">
                        <!-- Encabezado del documento -->
                        <div class="document-header text-center mb-4">
                            <h2>PLANTILLA DE ACTA DE ENTREGA</h2>
                            <hr>
                        </div>
                        
                        <!-- Información de la plantilla -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5><strong>Datos de la Plantilla</strong></h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Nombre:</th>
                                        <td>{{ $plantilla->nombre ?? 'Sin nombre' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tipo:</th>
                                        <td>
                                            <span class="badge bg-{{ $plantilla->tipo == 'produccion' ? 'danger' : 'warning' }}">
                                                {{ ucfirst($plantilla->tipo) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Estado:</th>
                                        <td>
                                            <span class="badge bg-{{ $plantilla->activa ? 'success' : 'secondary' }}">
                                                {{ $plantilla->activa ? 'Activa' : 'Inactiva' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Fecha de Creación:</th>
                                        <td>{{ $plantilla->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                            
                            <div class="col-md-6">
                                <h5><strong>Ejemplo de Uso</strong></h5>
                                <p class="text-muted">
                                    Esta plantilla se utilizará para crear actas de entrega con los siguientes datos predefinidos:
                                </p>
                            </div>
                        </div>
                        
                        <!-- Vista previa del contenido del acta -->
                        <div class="document-content">
                            <div class="section mb-4">
                                <h5><strong>Texto Introductorio</strong></h5>
                                <div class="content-preview border p-3">
                                    @if($plantilla->texto_introduccion)
                                        <p style="text-align: justify; white-space: pre-line;">{{ $plantilla->texto_introduccion }}</p>
                                    @else
                                        <p class="text-muted">No se ha definido texto introductorio para esta plantilla.</p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="section mb-4">
                                <h5><strong>Texto de Confidencialidad</strong></h5>
                                <div class="content-preview border p-3">
                                    @if($plantilla->texto_confidencialidad)
                                        <p style="text-align: justify; white-space: pre-line;">{{ $plantilla->texto_confidencialidad }}</p>
                                    @else
                                        <p class="text-muted">No se ha definido texto de confidencialidad para esta plantilla.</p>
                                    @endif
                                </div>
                            </div>
                            
                            @if($plantilla->encabezado_personalizado || $plantilla->pie_personalizado)
                            <div class="section mb-4">
                                <h5><strong>Elementos Personalizados</strong></h5>
                                @if($plantilla->encabezado_personalizado)
                                    <div class="mb-3">
                                        <h6>Encabezado Personalizado:</h6>
                                        <div class="content-preview border p-3">
                                            <p>{{ $plantilla->encabezado_personalizado }}</p>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($plantilla->pie_personalizado)
                                    <div>
                                        <h6>Pie Personalizado:</h6>
                                        <div class="content-preview border p-3">
                                            <p>{{ $plantilla->pie_personalizado }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @endif
                        </div>
                        
                        <!-- Vista previa de firmas (simulada) -->
                        <div class="signature-preview mt-5">
                            <h5><strong>Vista Previa de Firmas</strong></h5>
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <p><strong>ENTREGADO POR</strong></p>
                                    <div style="border-top: 1px solid #333; margin-top: 60px; padding-top: 10px;">
                                        {{ $plantilla->usuario->name ?? auth()->user()->name }}<br>
                                        <small class="text-muted">OFICINA DE APLICACIONES Y BASES DE DATOS</small>
                                    </div>
                                    @if(isset($plantilla->usuario) && $plantilla->usuario->ruta_firma)
                                        @php
                                            $rutaFirma = str_replace('public/', '', $plantilla->usuario->ruta_firma);
                                        @endphp
                                        @if(Storage::exists($rutaFirma))
                                            <div style="margin-top: 20px;">
                                                <img src="{{ public_path('storage/' . $rutaFirma) }}" 
                                                     alt="Firma" 
                                                     style="max-height: 60px; max-width: 200px;">
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <div class="col-md-6 text-center">
                                    <p><strong>RECEPCIONADO POR</strong></p>
                                    <div style="border-top: 1px solid #333; margin-top: 60px; padding-top: 10px;">
                                        [Nombre del Programador]<br>
                                        <small class="text-muted">[Oficina del Programador]</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.document-preview {
    background: white;
    padding: 30px;
    border: 1px solid #ddd;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    margin: 20px 0;
}

.document-header h2 {
    color: #333;
    margin-bottom: 10px;
}

.content-preview {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 5px;
    padding: 15px;
    min-height: 100px;
}

.content-preview p {
    margin-bottom: 0;
    line-height: 1.6;
}

.section h5 {
    color: #495057;
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 5px;
    margin-bottom: 15px;
}

.signature-preview {
    border-top: 2px solid #333;
    padding-top: 20px;
}
</style>
@endsection