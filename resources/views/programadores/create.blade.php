@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Crear Nuevo Programador</h5>
                </div>
                <div class="card-body">
                    <!-- Campo de búsqueda por RUT -->
                    <div class="mb-4">
                        <label for="buscar_rut" class="form-label">Buscar por RUT</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="buscar_rut" placeholder="Ingrese el RUT del programador (sin puntos y sin guión)">
                            <button class="btn btn-outline-secondary" type="button" id="btn_buscar_rut">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                    
                    <form id="form_programador" action="{{ route('programadores.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Completo *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico *</label>
                            <input type="email" class="form-control @error('correo') is-invalid @enderror" 
                                   id="correo" name="correo" value="{{ old('correo') }}" required>
                            @error('correo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="cargo" class="form-label">Grado *</label>
                            <input type="text" class="form-control @error('cargo') is-invalid @enderror" 
                                   id="cargo" name="cargo" value="{{ old('cargo') }}" required>
                            @error('cargo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="oficina" class="form-label">Dotacion</label>
                            <input type="text" class="form-control @error('oficina') is-invalid @enderror" 
                                   id="oficina" name="oficina" value="{{ old('oficina') }}">
                            @error('oficina')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="departamento" class="form-label">Otros datos relevantes (opcional)</label>
                            <input type="text" class="form-control @error('departamento') is-invalid @enderror" 
                                   id="departamento" name="departamento" value="{{ old('departamento') }}">
                            @error('departamento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="rut" class="form-label">RUT *</label>
                            <input type="text" class="form-control @error('rut') is-invalid @enderror" 
                                   id="rut" name="rut" value="{{ old('rut') }}" required>
                            @error('rut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="codigo_programador" class="form-label">Código</label>
                            <input type="text" class="form-control @error('codigo_programador') is-invalid @enderror" 
                                   id="codigo_programador" name="codigo_programador" value="{{ old('codigo_programador') }}">
                            @error('codigo_programador')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Observaciones (opcional)</label>
                            <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                                   id="telefono" name="telefono" value="{{ old('telefono') }}">
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('programadores.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Programador
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnBuscarRut = document.getElementById('btn_buscar_rut');
    const inputBuscarRut = document.getElementById('buscar_rut');
    const formProgramador = document.getElementById('form_programador');
    
    if (btnBuscarRut && inputBuscarRut) {
        btnBuscarRut.addEventListener('click', function() {
            const rut = inputBuscarRut.value.trim();
            if (rut) {
                buscarProgramadorPorRut(rut);
            } else {
                mostrarMensaje('Por favor ingrese un RUT', 'warning');
            }
        });
        
        inputBuscarRut.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const rut = inputBuscarRut.value.trim();
                if (rut) {
                    buscarProgramadorPorRut(rut);
                } else {
                    mostrarMensaje('Por favor ingrese un RUT', 'warning');
                }
            }
        });
    }
    
    function buscarProgramadorPorRut(rut) {
        // Mostrar indicador de carga
        const btnOriginalText = btnBuscarRut.innerHTML;
        btnBuscarRut.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Buscando...';
        btnBuscarRut.disabled = true;
        
        fetch(`/programadores/buscar-por-rut/${encodeURIComponent(rut)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Rellenar los campos del formulario con los datos encontrados
                    if (document.getElementById('nombre')) {
                        document.getElementById('nombre').value = data.programador.nombre || '';
                    }
                    // El correo lo dejamos vacío para que lo ingrese manualmente
                    if (document.getElementById('cargo')) {
                        document.getElementById('cargo').value = data.programador.cargo || '';
                    }
                    if (document.getElementById('oficina')) {
                        document.getElementById('oficina').value = data.programador.oficina || '';
                    }
                    if (document.getElementById('rut')) {
                        document.getElementById('rut').value = data.programador.rut || '';
                    }
                    if (document.getElementById('codigo_programador')) {
                        document.getElementById('codigo_programador').value = data.programador.codigo_programador || '';
                    }
                    
                    // Mostrar mensaje de éxito
                    mostrarMensaje('Datos del programador cargados exitosamente', 'success');
                } else {
                    mostrarMensaje(data.message || 'Programador no encontrado', 'warning');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarMensaje('Error al buscar el programador: ' + error.message, 'danger');
            })
            .finally(() => {
                // Restaurar botón
                btnBuscarRut.innerHTML = btnOriginalText;
                btnBuscarRut.disabled = false;
            });
    }
    
    function mostrarMensaje(mensaje, tipo) {
        // Remover mensajes anteriores
        const mensajesAnteriores = document.querySelectorAll('#mensaje-alerta');
        mensajesAnteriores.forEach(msg => msg.remove());
        
        // Crear nuevo mensaje
        const alertDiv = document.createElement('div');
        alertDiv.id = 'mensaje-alerta';
        alertDiv.className = `alert alert-${tipo} alert-dismissible fade show`;
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Insertar el mensaje antes del formulario
        if (formProgramador) {
            formProgramador.parentNode.insertBefore(alertDiv, formProgramador);
        }
        
        // Auto-ocultar mensaje de éxito después de 5 segundos
        if (tipo === 'success') {
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }
    }
});
</script>

@endsection
