@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Registrar Nuevo Usuario</h5>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver al Dashboard
                    </a>
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
                        <div class="form-text">Ingrese el RUT para buscar datos existentes del programador</div>
                    </div>
                    
                    <form method="POST" action="{{ route('admin.register.store') }}" id="form_usuario">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nombre</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cargo" class="col-md-4 col-form-label text-md-end">Cargo</label>

                            <div class="col-md-6">
                                <input id="cargo" type="text" class="form-control @error('cargo') is-invalid @enderror" name="cargo" value="{{ old('cargo') }}" readonly>

                                @error('cargo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="form-text">Este campo se completa automáticamente al buscar por RUT</div>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Correo Electrónico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="rol" class="col-md-4 col-form-label text-md-end">Rol</label>

                            <div class="col-md-6">
                                <select id="rol" class="form-control @error('rol') is-invalid @enderror" name="rol" required>
                                    <option value="">Seleccione un rol</option>
                                    <option value="admin" {{ old('rol') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                    <option value="consultor" {{ old('rol') == 'consultor' ? 'selected' : '' }}>Consultor</option>
                                </select>

                                @error('rol')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmar Contraseña</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-user-plus"></i> Registrar Usuario
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-2">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
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
    const formUsuario = document.getElementById('form_usuario');
    
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
        
        fetch(`/admin/usuarios/buscar-por-rut/${encodeURIComponent(rut)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Rellenar los campos del formulario con los datos encontrados
                    if (document.getElementById('name')) {
                        document.getElementById('name').value = data.programador.nombre || '';
                    }
                    // El correo lo dejamos vacío para que lo ingrese manualmente
                    if (document.getElementById('email')) {
                        document.getElementById('email').value = data.programador.correo || '';
                    }
                    // Almacenar el cargo en el campo oculto
                    if (document.getElementById('cargo')) {
                        document.getElementById('cargo').value = data.programador.cargo || '';
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
        if (formUsuario) {
            formUsuario.parentNode.insertBefore(alertDiv, formUsuario);
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