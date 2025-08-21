@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Crear Nuevo Servidor</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('servidores.store') }}" method="POST">
                        @csrf

		                <div class="mb-3">
                            <label for="nombre" class="form-label">Direccion IP</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                   id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder="Ej: 172.21.100.10">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notas_tecnicas" class="form-label">Reparticion</label>
                            <input type="text" class="form-control @error('notas_tecnicas') is-invalid @enderror"
                                      id="notas_tecnicas" name="notas_tecnicas" rows="4" placeholder="Reparticion de destino.">
                            @error('notas_tecnicas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo *</label>
                            <select class="form-control @error('tipo') is-invalid @enderror"
                                    id="tipo" name="tipo" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="desarrollo" {{ old('tipo') == 'desarrollo' ? 'selected' : '' }}>Desarrollo</option>
                                <option value="produccion" {{ old('tipo') == 'produccion' ? 'selected' : '' }}>Producción</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sistema_operativo" class="form-label">Sistema Operativo *</label>
                            <input type="text" class="form-control @error('sistema_operativo') is-invalid @enderror"
                                   id="sistema_operativo" name="sistema_operativo" value="{{ old('sistema_operativo') }}" required>
                            @error('sistema_operativo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cpu" class="form-label">CPU *</label>
                            <input type="text" class="form-control @error('cpu') is-invalid @enderror"
                                   id="cpu" name="cpu" value="{{ old('cpu') }}" required>
                            @error('cpu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ram" class="form-label">RAM *</label>
                            <input type="text" class="form-control @error('ram') is-invalid @enderror"
                                   id="ram" name="ram" value="{{ old('ram') }}" required placeholder="Ej: 16GB DDR4">
                            @error('ram')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="disco" class="form-label">Disco *</label>
                            <input type="text" class="form-control @error('disco') is-invalid @enderror"
                                   id="disco" name="disco" value="{{ old('disco') }}" required placeholder="Ej: 500GB SSD">
                            @error('disco')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('servidores.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-save"></i> Guardar Servidor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
