@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 text-dark">Crear Nuevo Encargado</h5>
                </div>
                <div class="card-body">
                    <!-- Campo de búsqueda por RUT -->
                    <div class="mb-4">
                        <label for="buscar_rut" class="form-label">Buscar por RUT</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="buscar_rut" placeholder="Ingrese el RUT del programador (sin puntos y sin guión)" onkeypress="if(event.key==='Enter'){event.preventDefault(); buscarProgramadorPorRut(this.value);}">
                            <button class="btn btn-outline-secondary" type="button" id="btn_buscar_rut" onclick="buscarProgramadorPorRut(document.getElementById('buscar_rut').value)">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                        <div class="form-text">Ingrese el RUT para buscar datos existentes del programador</div>
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
                                                
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('programadores.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-dark btn-outline-light">
                                <i class="fas fa-save"></i> Guardar Encargado
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function mostrarVistaPrevia() {
    // Prevenir el envío normal del formulario
    event.preventDefault();
    
    // Crear un formulario temporal para enviar los datos por POST
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("programadores.vista-previa-nueva") }}';
    form.target = '_blank';
    
    // Agregar el token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;
    form.appendChild(csrfInput);
    
    // Obtener todos los datos del formulario actual
    const currentForm = document.querySelector('form');
    const formData = new FormData(currentForm);
    
    // Agregar todos los campos del formulario al formulario temporal
    for (let [key, value] of formData.entries()) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    }
    
    // Agregar el formulario al body y enviarlo
    document.body.appendChild(form);
    form.submit();
    
    // Remover el formulario después de enviarlo
    document.body.removeChild(form);
}

// Función para buscar programador por RUT (usando la nueva ruta)
function buscarProgramadorPorRut(rut) {
    // Mostrar indicador de carga
    const btnBuscarRut = document.getElementById('btn_buscar_rut');
    const btnOriginalText = btnBuscarRut.innerHTML;
    btnBuscarRut.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Buscando...';
    btnBuscarRut.disabled = true;
    
    // Usar la ruta correcta CON la subruta gestion_actas
    fetch(`/gestion_actas/buscar-programador/${encodeURIComponent(rut)}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
        credentials: 'include'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Rellenar los campos del formulario con los datos encontrados
            if (document.getElementById('nombre')) {
                document.getElementById('nombre').value = data.programador.nombre || '';
            }
            if (document.getElementById('correo')) {
                document.getElementById('correo').value = data.programador.correo || '';
            }
            if (document.getElementById('cargo')) {
                document.getElementById('cargo').value = data.programador.cargo || '';
            }
            if (document.getElementById('oficina')) {
                document.getElementById('oficina').value = data.programador.oficina || '';
            }
            if (document.getElementById('departamento')) {
                document.getElementById('departamento').value = data.programador.departamento || '';
            }
            if (document.getElementById('rut')) {
                document.getElementById('rut').value = data.programador.rut || '';
            }
            if (document.getElementById('codigo_programador')) {
                document.getElementById('codigo_programador').value = data.programador.codigo_programador || '';
            }
            if (document.getElementById('telefono')) {
                document.getElementById('telefono').value = data.programador.telefono || '';
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
    const formProgramador = document.getElementById('form_programador');
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
</script>

@endsection
