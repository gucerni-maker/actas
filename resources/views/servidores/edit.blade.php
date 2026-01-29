@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark">Editar Servidor</h5>
                    <a href="{{ route('servidores.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('servidores.update', $servidor) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre/Identificador</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                   id="nombre" name="nombre" value="{{ old('nombre', $servidor->nombre) }}" placeholder="Ej: Servidor Web Principal">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo *</label>
                            <select class="form-control @error('tipo') is-invalid @enderror"
                                    id="tipo" name="tipo" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="desarrollo" {{ old('tipo', $servidor->tipo) == 'desarrollo' ? 'selected' : '' }}>Desarrollo</option>
                                <option value="produccion" {{ old('tipo', $servidor->tipo) == 'produccion' ? 'selected' : '' }}>Producción</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sistema_operativo" class="form-label">Sistema Operativo *</label>
                            <input type="text" class="form-control @error('sistema_operativo') is-invalid @enderror"
                                   id="sistema_operativo" name="sistema_operativo" value="{{ old('sistema_operativo', $servidor->sistema_operativo) }}" required>
                            @error('sistema_operativo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cpu" class="form-label">CPU *</label>
                            <input type="text" class="form-control @error('cpu') is-invalid @enderror"
                                   id="cpu" name="cpu" value="{{ old('cpu', $servidor->cpu) }}" required>
                            @error('cpu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ram" class="form-label">RAM *</label>
                            <input type="text" class="form-control @error('ram') is-invalid @enderror"
                                   id="ram" name="ram" value="{{ old('ram', $servidor->ram) }}" required placeholder="Ej: 16GB DDR4">
                            @error('ram')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="disco" class="form-label">Disco *</label>
                            <input type="text" class="form-control @error('disco') is-invalid @enderror"
                                   id="disco" name="disco" value="{{ old('disco', $servidor->disco) }}" required placeholder="Ej: 500GB SSD">
                            @error('disco')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notas_tecnicas" class="form-label">Reparticion</label>
                            <input type="text" class="form-control @error('notas_tecnicas') is-invalid @enderror"
                                      id="notas_tecnicas" name="notas_tecnicas" rows="4" value="{{ old('notas_tecnicas', $servidor->notas_tecnicas) }}">
                            @error('notas_tecnicas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('servidores.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-dark btn-outline-light">
                                <i class="fas fa-save"></i> Actualizar Servidor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
