@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Vista Previa del Programador</h5>
                    <div>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="window.print()">
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="window.close()">
                            <i class="fas fa-times"></i> Cerrar
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="preview-container">
                        <h3 class="text-center mb-4">DATOS DEL PROGRAMADOR</h3>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Nombre:</th>
                                        <td>{{ $programador->nombre }}</td>
                                    </tr>
                                    <tr>
                                        <th>RUT:</th>
                                        <td>{{ $programador->rut ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Cargo:</th>
                                        <td>{{ $programador->cargo }}</td>
                                    </tr>
                                    <tr>
                                        <th>Código:</th>
                                        <td>{{ $programador->codigo_programador ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                            
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Correo:</th>
                                        <td>{{ $programador->correo }}</td>
                                    </tr>
                                    <tr>
                                        <th>Teléfono:</th>
                                        <td>{{ $programador->telefono ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Oficina:</th>
                                        <td>{{ $programador->oficina ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Departamento:</th>
                                        <td>{{ $programador->departamento ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        @if($programador->ruta_firma)
                            @php
                                $rutaFirma = str_replace('public/', '', $programador->ruta_firma);
                            @endphp
                            @if(Storage::exists($rutaFirma))
                                <div class="text-center mt-4">
                                    <h6><strong>Firma Digital</strong></h6>
                                    <img src="{{ public_path('storage/' . $rutaFirma) }}" 
                                         alt="Firma" 
                                         style="max-height: 60px; max-width: 200px;">
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection