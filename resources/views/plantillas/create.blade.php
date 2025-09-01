@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark">Crear Nueva Plantilla de Acta</h5>
                    <a href="{{ route('plantillas.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('plantillas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la Plantilla *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                                                
                        <div class="mb-3">
                            <label for="texto_introduccion" class="form-label">Texto Introducción</label>
                            <textarea class="form-control @error('texto_introduccion') is-invalid @enderror" 
                                      id="texto_introduccion" name="texto_introduccion" rows="4">{{ old('texto_introduccion') }}</textarea>
                            @error('texto_introduccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="texto_confidencialidad" class="form-label">Texto Confidencialidad</label>
                            <textarea class="form-control @error('texto_confidencialidad') is-invalid @enderror" 
                                      id="texto_confidencialidad" name="texto_confidencialidad" rows="4">{{ old('texto_confidencialidad') }}</textarea>
                            @error('texto_confidencialidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="encabezado_personalizado" class="form-label">Encabezado Personalizado</label>
                            <textarea class="form-control @error('encabezado_personalizado') is-invalid @enderror" 
                                      id="encabezado_personalizado" name="encabezado_personalizado" rows="3">{{ old('encabezado_personalizado') }}</textarea>
                            @error('encabezado_personalizado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="pie_personalizado" class="form-label">Pie Personalizado</label>
                            <textarea class="form-control @error('pie_personalizado') is-invalid @enderror" 
                                      id="pie_personalizado" name="pie_personalizado" rows="3">{{ old('pie_personalizado') }}</textarea>
                            @error('pie_personalizado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                                                
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input @error('activa') is-invalid @enderror" 
                                   id="activa" name="activa" {{ old('activa', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="activa">Plantilla Activa</label>
                            @error('activa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('plantillas.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>

                            <button type="submit" class="btn btn-dark btn-outline-light">
                                <i class="fas fa-save"></i> Guardar Plantilla
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
