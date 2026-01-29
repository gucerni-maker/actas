@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark">Gestión de Firma Digital</h5>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver al Dashboard
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <h6>Firma Actual</h6>
                            @if($user->ruta_firma)
                                <div class="text-center mb-3">
                                    <!-- Mostrar firma actual -->
                                    @if($user->ruta_firma)
                                        @php
                                            // Extraer solo el nombre del archivo de la ruta
                                            $nombreArchivo = basename($user->ruta_firma);
                                            // Crear la ruta correcta para acceder al archivo
                                            $rutaCorrecta = '/gestion_actas/storage/firmas/' . $nombreArchivo;
                                        @endphp
                                        <div class="text-center mb-3">
                                            <strong>Firma Actual:</strong>
                                            <div class="mt-2">
                                                <img src="{{ $rutaCorrecta }}" 
                                                     alt="Firma actual" 
                                                     class="img-fluid border" 
                                                     style="max-height: 100px; max-width: 300px;">
                                            </div>
                                            <div class="mt-2 small text-muted">
                                                Archivo: {{ $nombreArchivo }}
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-muted">No tienes una firma cargada.</p>
                                    @endif
                                </div>
                                <form action="{{ route('profile.firma.delete') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar tu firma?')">
                                        <i class="fas fa-trash"></i> Eliminar Firma
                                    </button>
                                </form>
                            @else
                                <p class="text-muted">No tienes una firma cargada.</p>
                            @endif
                        </div>
                        
                        <div class="col-md-6">
                            <h6>Cargar Nueva Firma</h6>
                            <form action="{{ route('profile.firma.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="firma" class="form-label">Imagen de Firma</label>
                                    <input type="file" class="form-control @error('firma') is-invalid @enderror" 
                                           id="firma" name="firma" accept="image/*">
                                    @error('firma')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Formatos permitidos: PNG, JPG, JPEG. Máximo 2MB. Dimensiones recomendadas: 300x100px
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-dark btn-outline-light">
                                    <i class="fas fa-upload"></i> Cargar Firma
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Instrucciones</h6>
                        <ul class="mb-0">
                            <li>Escanea tu firma en un papel blanco</li>
                            <li>Recorta la imagen para que solo contenga la firma</li>
                            <li>Guarda la imagen en formato PNG con fondo transparente para mejores resultados</li>
                            <li>La firma se mostrará automáticamente en los PDF generados</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
