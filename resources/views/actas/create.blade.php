@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Crear Nueva Acta de Entrega</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('actas.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="fecha_entrega" class="form-label">Fecha de Entrega *</label>
                            <input type="date" class="form-control @error('fecha_entrega') is-invalid @enderror"
                                   id="fecha_entrega" name="fecha_entrega" value="{{ old('fecha_entrega') }}" required>
                            @error('fecha_entrega')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="programador_id" class="form-label">Encargado *</label>
                            <select class="form-control @error('programador_id') is-invalid @enderror"
                                    id="programador_id" name="programador_id" required>
                                <option value="">Seleccione un encargado</option>
                                @foreach($programadores as $programador)
                                    <option value="{{ $programador->id }}" {{ old('programador_id') == $programador->id ? 'selected' : '' }}>
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
                                    <option value="{{ $servidor->id }}" {{ old('servidor_id') == $servidor->id ? 'selected' : '' }}>
                                        {{ $servidor->descripcion_completa }}
                                    </option>
                                @endforeach
                            </select>
                            @error('servidor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campos adicionales -->

                        <div class="mb-3">
                            <label for="comuna" class="form-label">Comuna *</label>
                            <input type="text" class="form-control @error('comuna') is-invalid @enderror" 
                                   id="comuna" name="comuna" value="{{ old('comuna', 'Santiago') }}" required>
                            @error('comuna')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="oficina_origen" class="form-label">Oficina Origen *</label>
                            <input type="text" class="form-control @error('oficina_origen') is-invalid @enderror" 
                                   id="oficina_origen" name="oficina_origen" value="{{ old('oficina_origen', 'OFICINA DE APLICACIONES Y BASES DE DATOS') }}" required>
                            @error('oficina_origen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="oficina_destino" class="form-label">Oficina Destino *</label>
                            <input type="text" class="form-control @error('oficina_destino') is-invalid @enderror" 
                                   id="oficina_destino" name="oficina_destino" value="{{ old('oficina_destino', 'OFICINA DATA CENTER') }}" required>
                            @error('oficina_destino')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="texto_introduccion" class="form-label">Texto Introducción</label>
                            <textarea class="form-control @error('texto_introduccion') is-invalid @enderror" 
                                        id="texto_introduccion" name="texto_introduccion" rows="4" placeholder="Texto introductorio...">{{ old('texto_introduccion', 'La Oficina de Aplicaciones y Bases de Datos de la Sección Gestión de Servicios, hace entrega de la Administración total del Servidor Virtual, cuyas características se mencionan a continuación.') }}</textarea>
                            @error('texto_introduccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="texto_confidencialidad" class="form-label">Texto Confidencialidad</label>
                            <textarea class="form-control @error('texto_confidencialidad') is-invalid @enderror" 
                                        id="texto_confidencialidad" name="texto_confidencialidad" rows="4" placeholder="Texto sobre confidencialidad...">{{ old('texto_confidencialidad', 'Se hace presente la confidencialidad que se debe tener sobre la información que se hace entrega y el resguardo de la misma. Atendido a lo dispuesto en la Ley N° 21459 relativa a delitos informáticos, Ley Nº 19.628 sobre protección de la vida privada o protección de datos de carácter personal, Ley 20.285 acceso a la información pública y Artículo 436 código justicia militar.') }}</textarea>
                            @error('texto_confidencialidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                      id="observaciones" name="observaciones" rows="4">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>                                            
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('actas.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Acta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
