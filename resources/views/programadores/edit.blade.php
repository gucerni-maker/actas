@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark">Editar Encargado</h5>
                    <a href="{{ route('programadores.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('programadores.update', $programador) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre', $programador->nombre) }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico *</label>
                            <input type="email" class="form-control @error('correo') is-invalid @enderror" 
                                   id="correo" name="correo" value="{{ old('correo', $programador->correo) }}" required>
                            @error('correo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="cargo" class="form-label">Cargo *</label>
                            <input type="text" class="form-control @error('cargo') is-invalid @enderror" 
                                   id="cargo" name="cargo" value="{{ old('cargo', $programador->cargo) }}" required>
                            @error('cargo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="oficina" class="form-label">Oficina</label>
                            <input type="text" class="form-control @error('oficina') is-invalid @enderror" 
                                   id="oficina" name="oficina" value="{{ old('oficina', $programador->oficina) }}">
                            @error('oficina')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="departamento" class="form-label">Departamento</label>
                            <input type="text" class="form-control @error('departamento') is-invalid @enderror" 
                                   id="departamento" name="departamento" value="{{ old('departamento', $programador->departamento) }}">
                            @error('departamento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="rut" class="form-label">RUT *</label>
                            <input type="text" class="form-control @error('rut') is-invalid @enderror" 
                                   id="rut" name="rut" value="{{ old('rut', $programador->rut) }}" required>
                            @error('rut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="codigo_programador" class="form-label">Código de Programador</label>
                            <input type="text" class="form-control @error('codigo_programador') is-invalid @enderror" 
                                   id="codigo_programador" name="codigo_programador" value="{{ old('codigo_programador', $programador->codigo_programador) }}">
                            @error('codigo_programador')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                                   id="telefono" name="telefono" value="{{ old('telefono', $programador->telefono) }}">
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                                                
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('programadores.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-dark btn-outline-light">
                                <i class="fas fa-save"></i> Actualizar Encargado
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection