@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detalles de la Plantilla de Acta</h5>
                    <a href="{{ route('plantillas.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><strong>Datos de la Plantilla</strong></h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th>ID:</th>
                                    <td>{{ $plantilla->id }}</td>
                                </tr>
                                <tr>
                                    <th>Nombre:</th>
                                    <td>{{ $plantilla->nombre }}</td>
                                </tr>
                                <tr>
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
                                <tr>
                                    <th>Última Actualización:</th>
                                    <td>{{ $plantilla->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h6><strong>Texto Introducción</strong></h6>
                            <p>{{ $plantilla->texto_introduccion ?? 'No hay texto de introducción.' }}</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h6><strong>Texto Confidencialidad</strong></h6>
                            <p>{{ $plantilla->texto_confidencialidad ?? 'No hay texto de confidencialidad.' }}</p>
                        </div>
                    </div>
                    
                    @if($plantilla->encabezado_personalizado)
                    <div class="row">
                        <div class="col-md-12">
                            <h6><strong>Encabezado Personalizado</strong></h6>
                            <p>{{ $plantilla->encabezado_personalizado }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($plantilla->pie_personalizado)
                    <div class="row">
                        <div class="col-md-12">
                            <h6><strong>Pie Personalizado</strong></h6>
                            <p>{{ $plantilla->pie_personalizado }}</p>
                        </div>
                    </div>
                    @endif
                    
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('plantillas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                        <div>
                            <a href="{{ route('plantillas.preview', $plantilla) }}" class="btn btn-primary" target="_blank">
                                <i class="fas fa-search"></i> Vista Previa
                            </a>
                            <a href="{{ route('plantillas.edit', $plantilla) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('plantillas.destroy', $plantilla) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta plantilla?')">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
