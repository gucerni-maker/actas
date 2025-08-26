@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark">Editar Acta de Entrega #{{ $acta->id }}</h5>
                    <a href="{{ route('actas.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('actas.update', $acta) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="fecha_entrega" class="form-label">Fecha de Entrega *</label>
                            <input type="date" class="form-control @error('fecha_entrega') is-invalid @enderror" 
                                   id="fecha_entrega" name="fecha_entrega" value="{{ old('fecha_entrega', $acta->fecha_entrega->format('Y-m-d')) }}" required>
                            @error('fecha_entrega')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="programador_id" class="form-label">Programador *</label>
                            <select class="form-control @error('programador_id') is-invalid @enderror" 
                                    id="programador_id" name="programador_id" required>
                                <option value="">Seleccione un programador</option>
                                @foreach($programadores as $programador)
                                    <option value="{{ $programador->id }}" {{ old('programador_id', $acta->programador_id) == $programador->id ? 'selected' : '' }}>
                                        {{ $programador->nombre }} ({{ $programador->correo }})
                                    </option>
                                @endforeach
                            </select>
                            @error('programador_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="servidor_id" class="form-label">Servidor *</label>
                            <select class="form-control @error('servidor_id') is-invalid @enderror" 
                                    id="servidor_id" name="servidor_id" required>
                                <option value="">Seleccione un servidor</option>
                                @foreach($servidores as $servidor)
                                    <option value="{{ $servidor->id }}" {{ old('servidor_id', $acta->servidor_id) == $servidor->id ? 'selected' : '' }}>
                                        {{ $servidor->descripcion_completa }}
                                    </option>
                                @endforeach
                            </select>
                            @error('servidor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                      id="observaciones" name="observaciones" rows="4">{{ old('observaciones', $acta->observaciones) }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('actas.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-dark btn-outline-light">
                                <i class="fas fa-save"></i> Actualizar Acta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
