@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark">Lista de Plantillas de Actas</h5>
                    <a href="{{ route('plantillas.create') }}" class="btn btn-dark btn-outline-light">
                        <i class="fas fa-plus"></i> Nueva Plantilla
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($plantillas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-dark">ID</th>
                                        <th class="text-dark">Nombre</th>
                                        <th class="text-dark">Estado</th>
                                        <th class="text-dark">Fecha de Creación</th>
                                        <th class="text-dark">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($plantillas as $plantilla)
                                        <tr>
                                            <td>{{ $plantilla->id }}</td>
                                            <td>{{ $plantilla->nombre }}</td>
                                            <td>
                                                <span class="badge bg-{{ $plantilla->activa ? 'success' : 'secondary' }}">
                                                    {{ $plantilla->activa ? 'Activa' : 'Inactiva' }}
                                                </span>
                                            </td>
                                            <td>{{ $plantilla->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('plantillas.show', $plantilla) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                                <a href="{{ route('plantillas.vista-previa-pdf', $plantilla) }}" class="btn btn-primary btn-sm" target="_blank">
                                                    <i class="fas fa-search"></i> Vista Previa
                                                </a>
                                                <a href="{{ route('plantillas.edit', $plantilla) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                <form action="{{ route('plantillas.destroy', $plantilla) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta plantilla?')">
                                                        <i class="fas fa-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $plantillas->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <p>No hay plantillas registradas.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
